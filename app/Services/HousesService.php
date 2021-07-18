<?php


namespace App\Services;


use App\Models\House\Estate;
use App\Models\House\House;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\BrowserKit\HttpBrowser as GoutteClient;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\UriResolver;

class HousesService
{
    /**
     * @param Collection|Estate $estate
     * @return array
     * @throws \Exception
     */
    public function scrape(Collection|Estate $estates)
    {
        $client = new GoutteClient();

        $houses = [];

        // Create collection out of estates if needed
        $estates = collect($estates);

        try {
            foreach($estates as $estate) {
                \Log::debug("Scraping $estate->id: $estate->name $estate->url");

                $scraper = $client->request('GET', $estate->url);

                $scraper
                    ->filter($estate->selector_all)
                    ->filter($estate->selector_each)
                    ->each(function (Crawler $node) use ($estate, &$houses) {
                        $estate_id = $estate->id;
                        \Log::debug('Got id');

                        $name = $node->filter($estate->selector_name)->text();
                        \Log::debug('Got name '.$name);

                        // Create realiable house link
                        $link = $node->filter($estate->selector_link)->first()->attr('href');
                        $link = UriResolver::resolve($link, $estate->url);

                        \Log::debug('Got link '.$link);

                        // Try <img> and style="background-image"
                        try {
                            // Try normal image
                            $photo = $node->filter($estate->selector_photo)->image()->getUri();
                        } catch (\Exception $e) {
                            // Try style
                            $photoStyle = $node->filter($estate->selector_photo)->attr("style");
                            preg_match('/(?<=url\().+?(?=\))/', $photoStyle, $matches);
                            $photo = UriResolver::resolve($matches[0], $estate->url);
                        }
                        \Log::debug('Got photo '.$photo);

                        $description = implode('\n', $node->filter($estate->selector_description)->each(fn($node) => $node->text()));
                        \Log::debug('Got description');

                        $price = $node->filter($estate->selector_price)->text();
                        \Log::debug('Got price');

                        $raw = $node->html();
                        \Log::debug('Got raw');

                        // Push house values to array
                        array_push($houses, compact('name', 'estate_id', 'description', 'photo', 'price', 'link', 'raw'));
                    });
            }
        } catch(\Exception $e) {
            $this->error('Something went wrong during scraping');
            $this->error(':'.$e->getLine().' '.$e->getMessage());
            throw $e;
        }

        \Log::debug('Found '.count($houses).' houses.');
        return $houses;

    }

}
