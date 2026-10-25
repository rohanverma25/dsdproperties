<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Disabled 2026-10-18: the daily auto-fetch published duplicate, off-topic
        // stories (71 were hidden). News is now written by hand.
        // $schedule->command('news:fetch')
        //          ->dailyAt('08:00')
        //          ->timezone('Asia/Kolkata')
        //          ->withoutOverlapping()
        //          ->runInBackground()
        //          ->appendOutputTo(storage_path('logs/news-fetch.log'));

        // Weekly newsletter: one small batch an hour (Hostinger mailbox limits), daytime only.
        // Needs the server cron:  * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
        $schedule->command('newsletter:send-batch')
                 ->hourly()
                 ->between('9:00', '20:00')
                 ->timezone('Asia/Kolkata')
                 ->withoutOverlapping()
                 ->appendOutputTo(storage_path('logs/newsletter.log'));
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
