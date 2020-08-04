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
        '\App\Console\Commands\AvicennaAndonMutation',
        '\App\Console\Commands\EmailDashboard',
        '\App\Console\Commands\AvicennaUpdateError',
        '\App\Console\Commands\FurnaceNotification',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('CopyAndonHourly:CopyAndon')
                 ->everyFiveMinutes();
        $schedule->command('EmailTraceability')
                 ->hourly();

        // Pindah dari manual php ke trigger mysql
        /* update error date ketika abnormal pada tabel avi_andon_status */
        // $schedule->command('avicenna:updateerror')
        //          ->everyMinute();

        /* insert mutasi dari andon */
        $schedule->command('avicenna:andonMutation')
                 ->everyMinute();

        /* email alert saat terjadi abnormality */
        $schedule->command('avicenna:emailDashboard')
                 ->everyMinute();

        $schedule->command('furnace:send')
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