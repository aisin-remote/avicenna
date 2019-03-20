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
        '\App\Console\Commands\EmailTraceability',
        '\App\Console\Commands\AlcollaOperationStatus',
        '\App\Console\Commands\AlcollaProductionResult',
        '\App\Console\Commands\AlcollaDownTimeStatus',
        '\App\Console\Commands\AvicennaAndonMutation'
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
        $schedule->command('EmailTraceability')
                 ->hourly();

        //For Insert Table SQL ALCOLLA TT_DATA_OPERATION_STATUS
        $schedule->command('alcolla:operationStatus')
                 ->everyMinute();

        /* For Insert Table AVICENNA avi_mutation */
        $schedule->command('avicenna:andonMutation')
                 ->everyMinute();
        
        /* For Insert Table SQL ALCOLLA TT_PODUCTION_RESULT */
        $schedule->command('alcolla:productionResult')
                 ->everyMinute();

        /* For Insert Table SQL ALCOLLA TT_DATA_DOWN_STATUS */
        $schedule->command('alcolla:downtimeStatus')
                 ->everyMinute();
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