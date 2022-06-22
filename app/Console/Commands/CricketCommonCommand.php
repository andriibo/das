<?php

namespace App\Console\Commands;

use App\Enums\SportIdEnum;
use App\Repositories\LeagueRepository;
use App\Services\Cricket\CreateCricketGameSchedulesService;
use App\Services\Cricket\CreateCricketTeamsPlayersUnitsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketCommonCommand extends Command
{
    protected $signature = 'cricket:common';

    protected $description = 'Get common data for Cricket from Goalserve';

    public function handle(
        LeagueRepository $leagueRepository,
        CreateCricketTeamsPlayersUnitsService $createCricketTeamsPlayersUnitsService,
        CreateCricketGameSchedulesService $createCricketGameScheduleService
    ) {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueRepository->getListBySportId(SportIdEnum::cricket);
        foreach ($leagues as $league) {
            $createCricketTeamsPlayersUnitsService->handle($league);
            $createCricketGameScheduleService->handle($league);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
