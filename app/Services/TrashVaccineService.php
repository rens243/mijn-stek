<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use App\Services\Helpers\TrashVaccineLocation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use voku\helper\HtmlDomParser;


class TrashVaccineService
{

    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $notAvailableInfo;

    /**
     * TrashVaccineService constructor.
     */
    public function __construct()
    {
        $this->url = env('VACCINE_URL');
        $this->notAvailableInfo = 'Gegevens pas beschikbaar tijdens prikmoment.';
    }

    /**
     * @throws \ErrorException
     */
    public function emailAvailableVaccineLocations() {
        // Get html of available locations
        $scrapedLocations = $this->scrapeLocations()
            ->where('info', '!=', $this->notAvailableInfo);

        // Do nothing if empty
        if ($scrapedLocations->isEmpty()) return;

        // Add it all to the body
        $body = $scrapedLocations
            ->map(fn($location) => $location->html)
            ->reduce(fn($carry, $item) => $carry.'<br>'.$item, '');
        $url = $this->url;
        $body = $body."<p><a href=\"$url\">$url</a></p>";

        // SEND IT
        $this->sendEmail($body);
    }

    /**
     * Scrape locations from website
     *
     * @return \Illuminate\Support\Collection|null
     * @throws \ErrorException
     */
    protected function scrapeLocations(): ?\Illuminate\Support\Collection
    {
         $response = Http::get($this->url);
         if (!$response->ok()) {
             throw new \ErrorException('Response not ok'. $response->status());
         }

         $dom = HtmlDomParser::str_get_html(
             $response->body()
         );

         $locationsContainer = $dom->findOneOrFalse('#locations-container');

         if (!$locationsContainer) return null;

         $locations = collect([]);

         foreach($locationsContainer->childNodes() as $child) {
             if ($child->nodeName !== 'div') continue;

             $currentLocation = new TrashVaccineLocation();

             // Set raw html
             $currentLocation->setHtml($child->html());

             // Get info from title
             $cardTitle = $child->findOne('.card-title');
             $currentLocation->id = $cardTitle->getAttribute('id');
             $currentLocation->subtitle = trim( $cardTitle->text());

             // Remove title
             $cardTitle->outerText = '';

             // Set info
             $info = '';
             foreach($child->find('p') as $pElement) {
                 $text = $pElement->text();
                 if(empty($text)) continue;
                 $info = $info.' '.$text;
             }
             $currentLocation->info = trim($info);

             // Locations
             $locations->push($currentLocation);
         }

         return $locations;
    }

    /**
     * Sends emails about vaccin
     */
    public function sendEmail($body)
    {
        Mail::send([], [], function ($message) use ($body) {
            $message->to(env('MAIL_VACCINE_ADDRESS'))
                ->subject(env('MAIL_VACCINE_SUBJECT'))
                ->setBody($body, 'text/html');
            });
    }

}
