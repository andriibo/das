<?php

namespace App\Console\Commands;

use App\Dto\CricketUnitDto;
use App\Helpers\UnitStatsHelper;
use App\Models\CricketPlayer;
use App\Models\CricketUnit;
use App\Models\CricketUnitStats;
use App\Services\ActionPointsService;
use App\Services\CricketPlayerService;
use App\Services\CricketUnitService;
use App\Services\CricketUnitStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

class CricketCalcPlayerFantasyPointsCommand extends Command
{
    protected $signature = 'cricket:calc-total-fantasy-points';

    protected $description = 'Calculate total unit stats';

    public function handle(
        CricketPlayerService $cricketPlayerService,
        ActionPointsService $actionPointsService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketPlayers = $cricketPlayerService->getCricketPlayers();
        $actionPoints = $actionPointsService->getMappedActionPoints();

        foreach ($cricketPlayers as $cricketPlayer) {
            $this->updatePlayerFantasyPoints($cricketPlayer, $actionPoints);
        }
    }

    private function updatePlayerFantasyPoints(CricketPlayer $player, array $actionPoints): void
    {
        $cricketUnitStatsService = resolve(CricketUnitStatsService::class);
        $cricketUnitService = resolve(CricketUnitService::class);

        foreach ($player->cricketUnits as $cricketUnit) {
            $unitStats = $cricketUnitStatsService->getRealGameUnitStatsByUnitId($cricketUnit->id);
            $cricketUnitDto = $this->calcFantasyPoints($unitStats, $actionPoints, $cricketUnit);
            $cricketUnitService->updateFantasyPoints($cricketUnit, $cricketUnitDto);
        }
    }

    private function calcFantasyPoints(
        Collection $unitStats,
        array $actionPoints,
        CricketUnit $cricketUnit
    ): CricketUnitDto {
        $unitDto = new CricketUnitDto();
        $unitDto->id = $cricketUnit->id;
        $unitDto->totalFantasyPoints = 0;
        $unitDto->totalFantasyPointsPerGame = 0;
        if (count($unitStats) && $cricketUnit->position) {
            /** @var CricketUnitStats $unitStat */
            foreach ($unitStats as $unitStat) {
                $unitDto->totalFantasyPoints += UnitStatsHelper::calcFantasyPointsForStats(
                    $unitStat->stats,
                    $actionPoints,
                    $cricketUnit->position
                );
            }
            $unitDto->totalFantasyPointsPerGame = $unitDto->totalFantasyPoints / count($unitStats);
        }

        return $unitDto;
    }
}
