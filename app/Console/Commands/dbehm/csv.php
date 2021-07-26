<?php

namespace App\Console\Commands\dbehm;

use Illuminate\Console\Command;

class csv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dbehm:csv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'google places api results to csv';

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
        $csvRoot = storage_path('dbehm/csv');
        $jsonRoot = storage_path('dbehm/json');
        $jFilenames = array_diff(scandir($jsonRoot), ['.', '..']);

        $fp = fopen($csvRoot.'/output.csv', 'w');

        $dictionary = collect([
            'name' => 'name',
            'place_id' => 'place_id',
            'address' => 'vicinity',
            'business_status' => 'business_status',
            'lat' => 'geometry.location.lat',
            'lng' => 'geometry.location.lng',
            'type' => 'types.0',
            'rating' => 'rating',
            'user_ratings_total' => 'user_ratings_total'
        ]);

        $header = $dictionary->keys();
        fputcsv($fp, $header->toArray());

        foreach($jFilenames as $jFilename) {
            $jContents = file_get_contents($jsonRoot.'/'.$jFilename);
            $data = json_decode($jContents, true);
            $data = collect($data['results']);

            foreach ($data as $row)
            {
                $row = collect($row);

                $rowItem = [];
                $dictionary->each(function($itemName) use (&$rowItem, $row) {
                    $rowItem[] = data_get($row, $itemName);
                });

                fputcsv($fp, $rowItem);
            }
        }

        fclose($fp);

        return 0;
    }
}
