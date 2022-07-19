<?php

namespace App\Console\Commands;

use App\Enums\SportIdEnum;
use App\Repositories\LeagueRepository;
use App\Services\Cricket\CreateCricketGameSchedulesService;
use App\Services\Cricket\CreateCricketTeamsPlayersUnitsService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CricketCommonCommand extends Command
{
    protected $signature = 'cricket:common';

    protected $description = 'Get common data for Cricket from Goalserve';

    public function handle(
        LeagueRepository $leagueRepository,
        CreateCricketTeamsPlayersUnitsService $createCricketTeamsPlayersUnitsService,
        CreateCricketGameSchedulesService $createCricketGameSchedulesService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueRepository->getListBySportId(SportIdEnum::cricket);
        foreach ($leagues as $league) {
            if (!$league->isExistLeagueIdParam()) {
                Log::channel('stderr')->error("League ID {$league->id} doesn't have league_id in the params.");

                continue;
            }

            $createCricketTeamsPlayersUnitsService->handle($league);
            $createCricketGameSchedulesService->handle($league);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
