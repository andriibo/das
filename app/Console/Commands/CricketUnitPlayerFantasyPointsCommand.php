<?php

namespace App\Console\Commands;

use App\Repositories\Cricket\CricketPlayerRepository;
use App\Services\ActionPointsService;
use App\Services\UpdateCricketPlayerFantasyPointsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketUnitPlayerFantasyPointsCommand extends Command
{
    protected $signature = 'cricket:unit-player-fantasy-points';

    protected $description = 'Calculate fantasy points for cricket units and players';

    public function handle(
        CricketPlayerRepository $cricketPlayerRepository,
        ActionPointsService $actionPointsService,
        UpdateCricketPlayerFantasyPointsService $updateCricketPlayerFantasyPointsService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketPlayers = $cricketPlayerRepository->getList();
        $actionPoints = $actionPointsService->getMappedActionPoints();
        foreach ($cricketPlayers as $cricketPlayer) {
            $updateCricketPlayerFantasyPointsService->handle($cricketPlayer, $actionPoints);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
