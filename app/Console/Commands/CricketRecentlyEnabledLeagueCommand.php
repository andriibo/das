<?php

namespace App\Console\Commands;

use App\Enums\LeagueRecentlyEnabledEnum;
use App\Enums\SportIdEnum;
use App\Models\League;
use App\Repositories\LeagueRepository;
use App\Services\Cricket\ConfirmHistoricalCricketGameSchedulesService;
use App\Services\Cricket\CreateCricketGameSchedulesService;
use App\Services\Cricket\CreateCricketStatsService;
use App\Services\Cricket\CreateCricketTeamsPlayersUnitsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketRecentlyEnabledLeagueCommand extends Command
{
    protected $signature = 'cricket:recently-enabled-league';

    protected $description = 'Run recently enabled leagues';

    public function handle(
        LeagueRepository $leagueRepository,
        CreateCricketTeamsPlayersUnitsService $createCricketTeamsPlayersUnitsService,
        CreateCricketGameSchedulesService $createCricketGameSchedulesService,
        CreateCricketStatsService $createCricketStatsService,
        ConfirmHistoricalCricketGameSchedulesService $confirmHistoricalCricketGameSchedulesService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueRepository->getRecentlyEnabledListBySportId(SportIdEnum::cricket);
        foreach ($leagues as $league) {
            $createCricketTeamsPlayersUnitsService->handle($league);
            $createCricketGameSchedulesService->handle($league);
            $createCricketStatsService->handle($league);
            $confirmHistoricalCricketGameSchedulesService->handle($league->id);
            $this->recentlyEnableLeague($league);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function recentlyEnableLeague(League $league)
    {
        $league->recently_enabled = LeagueRecentlyEnabledEnum::no;
        $league->save();
    }
}
