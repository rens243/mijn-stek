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
     * @var HousesService
     */
    protected HousesService $housesService;

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

        $this->housesService->scrape($estates, !$this->option('no-save'), !$this->option('no-mail'));

        \Log::debug('Scrape command done :)');

        return 0;
    }

}
