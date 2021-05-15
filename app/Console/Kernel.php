<?php

namespace App\Console;

use App\Services\TrashVaccineService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // dependency injection? idk.
        // Send vaccine reminder
        $trashVaccineService = new TrashVaccineService();
        $schedule
            ->call(fn() =>
                $trashVaccineService->emailAvailableVaccineLocations()
            )->everyMinute()
            ->between('7:51', '17:00')
            ->days([1,2,3,4,5,6]); // No sundays
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
