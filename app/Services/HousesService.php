<?php


namespace App\Services;


use App\Models\House\Estate;
use App\Models\House\House;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\UriResolver;

class HousesService
{

    /**
     *
     */
    protected function saveScrapedHouses($houses)
    {
        \Log::debug('Upserting...');
        House::query()
            ->upsert($houses, ['name', 'description']);
    }

    /**
     *
     */
    protected function emailScrapedHouses()
    {
        // Send emails or smth
        $users = User::query()
            ->where('email_houses', '=', true)
            ->get();

        // Send emails or smth
    }

    /**
     * Scrape estates for new houses
     *
     * @param Collection|Estate $estate
     * @return boolean
     */
    public function scrape(Collection|Estate $estates, bool $save = false, bool $email = false)
    {
        // Create guzzle client
        $guzzleClient = new GuzzleClient();

        // Create collection out of estates if needed
        $estates = collect($estates);

        // Create requests generator
        $requests = function() use ($estates) {
            foreach($estates as $estate) {
                yield new Request('GET', $estate->url);
            }
        };

        // Initialize houses array
        $houses = [];

        // Guzzle async pool
        $pool = new Pool($guzzleClient, $requests(), [
            'fulfilled' => function (Response $response, $index) use ($estates, $houses) {
                // This is delivered each successful response

                // Current estate being crawled
                $estate = $estates[$index];

                \Log::debug('fulfilled '.$estate->url);

                // Create crawler from response
                $crawler = new Crawler(null, $estates[$index]->url);
                $crawler->addContent(
                    (string) $response->getBody(),
                    $response->getHeader('Content-Type')[0]
                );

                // Get all houses
                $crawler
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

                        $description = implode(
                            '\n',
                            $node->filter($estate->selector_description)
                                ->each(fn($node) => $node->text())
                        );
                        \Log::debug('Got description');

                        $price = $node->filter($estate->selector_price)->text();
                        \Log::debug('Got price');

                        $raw = $node->html();
                        \Log::debug('Got raw');

                        // Push house values to array
                        array_push($houses, compact('name', 'estate_id', 'description', 'photo', 'price', 'link', 'raw'));
                    });
            },
            'rejected' => function (RequestException $reason, $index) {
                // this is delivered each failed request
                \Log::error('rejected :'.$reason->getLine().' '.$reason->getMessage());
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        // Save houses in database
        if($save) {
            $this->saveScrapedHouses($houses);
        }

        // Email if needed
        if ($email) {
            $this->emailScrapedHouses();
        }

        // Return new houses, ready to be upserted.
        return true;
    }

}
