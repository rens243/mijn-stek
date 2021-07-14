<?php

namespace App\Console\Commands\House;

use App\Models\House\Estate;
use App\Models\House\House;
use Goutte\Client as GoutteClient;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;


class Scrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'house:scrape {estate?} {--mail}';

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

        foreach($estates as $estate) {
            $this->info($estate->toJson());

            $scraper = $client->request('GET', $estate->url);

            $scraper
                ->filter($estate->selector_all)
                ->filter($estate->selector_each)
                ->each(function (Crawler $node) use ($estate, &$houses) {
                    // Set House values and push to array
                    array_push($houses, [
                        'name' => $node->filter($estate->selector_name)->text(),
                        'estate_id' => $estate->id,
                        'description' => implode('<br/>', $node->filter($estate->selector_description)->each(fn($node) => $node->text())),
                        'photo' => $node->filter($estate->selector_photo)->image()->getUri(),
                        'price' => $node->filter($estate->selector_price)->text(),
                        'link' => $node->filter($estate->selector_link)->first()->attr('href'),
                        'raw' => $node->html(),
                    ]);
                });
        }

        $this->info(json_encode($houses, JSON_PRETTY_PRINT));

        House::upsert($houses, ['name', 'description']);

        return 0;
    }
}
