<?php

namespace App\Console;

use App\Console\Commands\CricketGameScheduleCommand;
use App\Console\Commands\CricketPlayerSalaryCommand;
use App\Console\Commands\CricketTeamPlayerUnitCommand;
use App\Console\Commands\CricketUnitPlayerFantasyPointsCommand;
use App\Console\Commands\CricketUnitStatsTotalCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(CricketTeamPlayerUnitCommand::class)->dailyAt('00:00');
        $schedule->command(CricketGameScheduleCommand::class)->dailyAt('00:00');

        $schedule->command(CricketUnitStatsTotalCommand::class)->twiceDaily();
        $schedule->command(CricketUnitPlayerFantasyPointsCommand::class)->twiceDaily();
        $schedule->command(CricketPlayerSalaryCommand::class)->twiceDaily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
