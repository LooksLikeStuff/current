<?php

namespace App\Console;

use App\Http\Services\DateService;
use App\Jobs\Exchanges\MOEX\FetchPricesByDate;
use App\Jobs\Exchanges\MOEX\FetchTodayPrices;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
//         $schedule->command('inspire')->hourly();
        $schedule->job(new FetchTodayPrices())->everyFiveMinutes();
        $schedule->job(new FetchPricesByDate(DateService::yesterday()))->dailyAt('11:00');
        $schedule->job(new FetchPricesByDate(DateService::yesterday()))->dailyAt('00:15');
        $schedule->job(new FetchPricesByDate(DateService::yesterday()))->dailyAt('06:30');
        $schedule->call(fn() => \Cache::clear())->dailyAt('00:15');
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
