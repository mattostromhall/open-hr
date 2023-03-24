<?php

namespace App\Console;

use Domain\Files\Commands\ScaffoldDefaults;
use Domain\Notifications\Models\Notification;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ScaffoldDefaults::class
    ];
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('model:prune', [
            '--model' => [Notification::class],
        ])->daily();

        $schedule->command('cache:prune-stale-tags')
            ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
