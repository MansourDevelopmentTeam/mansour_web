<?php

namespace App\Console;

use App\Jobs\UpdateOrderPickupStatus;
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
        'App\Console\Commands\CallRoute',
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        //  * * * * * php /c/laragon/www/soleek-lap/{project-name}/artisan schedule:run >> /dev/null 2>&1

        /// artisan" pickups:refresh > "NUL" 2>&1
        // $schedule->command('pickups:refresh')->withoutOverlapping()->everyMinute();

        $schedule->job(new UpdateOrderPickupStatus())->withoutOverlapping()->everyFiveMinutes();
        // $schedule->command('orders:recurring')->dailyAt('00:00');
        // $schedule->command('orders:scheduled')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
