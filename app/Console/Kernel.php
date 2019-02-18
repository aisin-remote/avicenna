<?php

namespace App\Console;

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
        '\App\Console\Commands\DeleteEveryMonth',
        '\App\Console\Commands\CopyAndonHourly',
        '\App\Console\Commands\MutasiAndon',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('DeleteEveryMonth:DeleteMutations')
                 ->hourly();
        $schedule->command('CopyAndonHourly:CopyAndon')
                 ->everyFiveMinutes();
        $schedule->command('Andon:Mutation')
                 ->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
