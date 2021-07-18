<?php

namespace App\Console\Commands\House;

use App\Models\House\Estate;
use App\Models\House\House;
use App\Models\User;
use App\Services\HousesService;
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
    protected $signature = 'house:scrape {estate?} {--no-mail} {--no-save}';

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
    public function __construct(HousesService $housesService)
    {
        $this->housesService = $housesService;
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

        $estateId = $this->argument('estate');
        if ($estateId) {
            $estates = Estate::query()
                ->where('id', '=',$estateId)
                ->get();
        } else {
            $estates = Estate::query()
                ->where('active', '=',true)
                ->where('updated_at', '<', \Carbon\Carbon::now()->subMinutes(5)->toDateTimeString())
                ->get();
        }

        $houses = [];

        try {
            foreach($estates as $estate) {
                $this->info("Scraping $estate->id: $estate->name $estate->url");

                $scraper = $client->request('GET', $estate->url);

                $scraper
                    ->filter($estate->selector_all)
                    ->filter($estate->selector_each)
                    ->each(function (Crawler $node) use ($estate, &$houses) {
                        $estate_id = $estate->id;
                        $this->info('Got id');

                        $name = $node->filter($estate->selector_name)->text();
                        $this->info('Got name '.$name);

                        // Create realiable house link
                        $link = $node->filter($estate->selector_link)->first()->attr('href');
                        $link = UriResolver::resolve($link, $estate->url);

                        $this->info('Got link '.$link);

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
                        $this->info('Got photo '.$photo);

                        $description = implode('\n', $node->filter($estate->selector_description)->each(fn($node) => $node->text()));
                        $this->info('Got description');

                        $price = $node->filter($estate->selector_price)->text();
                        $this->info('Got price');

                        $raw = $node->html();
                        $this->info('Got raw');

                        // Push house values to array
                        array_push($houses, compact('name', 'estate_id', 'description', 'photo', 'price', 'link', 'raw'));
                    });
            }
        } catch(\Exception $e) {
            $this->error('Something went wrong during scraping');
            $this->error(':'.$e->getLine().' '.$e->getMessage());
            return 1;
        }

        $this->info('Found '.count($houses).' houses.');

        // Save if 'no-save' option is false
        if (!$this->option('no-save')) {
            $this->info('Upserting...');
            House::query()
                ->upsert($houses, ['name', 'description']);
        }

        // Send emails
        if (!$this->option('no-mail')) {
            $users = User::query()
                ->where('email_houses', '=', true)
                ->get();

            // Send emails or smth
        }

        $this->info('Scrape done :)');

        return 0;
    }

}
