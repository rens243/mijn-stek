<?php

namespace App\Console\Commands\House;

use App\Models\House\Estate;
use App\Models\House\House;
use Goutte\Client as GoutteClient;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\UriResolver;


class Scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'house:scrape {estate?} {--mail} {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scraping some houses, you know you know.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new GoutteClient();

        $houses = [];

        $estates = Estate::query()
            ->get();

        try {
            foreach($estates as $estate) {
                $this->info("Scraping $estate->id: $estate->name $estate->url");

                $scraper = $client->request('GET', $estate->url);

                $scraper
                    ->filter($estate->selector_all)
                    ->filter($estate->selector_each)
                    ->each(function (Crawler $node) use ($estate, &$houses) {
                        // Create realiable house link
                        $houseLink = $node->filter($estate->selector_link)->first()->attr('href');
                        $houseLink = UriResolver::resolve($houseLink, $estate->url);

                        // Set House values and push to array
                        array_push($houses, [
                            'name' => $node->filter($estate->selector_name)->text(),
                            'estate_id' => $estate->id,
                            'description' => implode('\n', $node->filter($estate->selector_description)->each(fn($node) => $node->text())),
                            'photo' => $node->filter($estate->selector_photo)->image()->getUri(),
                            'price' => $node->filter($estate->selector_price)->text(),
                            'link' => $houseLink,
                            'raw' => $node->html(),
                        ]);
                    });
            }
        } catch(\Exception $e) {
            $this->error('Something went wrong during scraping');
            $this->error(':'.$e->getLine().' '.$e->getMessage());
            return 1;
        }

        House::query()
            ->upsert($houses, ['name', 'description']);

        $this->info('scrape done :)');

        return 0;
    }
}
