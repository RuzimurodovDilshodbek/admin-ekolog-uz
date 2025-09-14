<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\SendTelegramPost::class
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('send:telegram-posts')->everyMinute(); // har daqiqada rejalangan postni telegramga jo'natish
//        $schedule->command('send:facebook-posts')->everyMinute(); // har daqiqada rejalangan postni telegramga jo'natish
//        $schedule->command('send:twitter-posts')->everyMinute(); // har daqiqada rejalangan postni telegramga jo'natish
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
