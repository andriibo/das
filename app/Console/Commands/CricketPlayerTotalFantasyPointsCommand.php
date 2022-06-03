<?php

namespace App\Console\Commands;

use App\Dto\CricketPlayerDto;
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

class CricketPlayerTotalFantasyPointsCommand extends Command
{
    protected $signature = 'cricket:player-total-fantasy-points';

    protected $description = 'Calculate total fantasy points and total fantasy points per game for cricket player';

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
        /* @var $cricketPlayerService CricketPlayerService */
        $cricketPlayerService = resolve(CricketPlayerService::class);

        $playerDto = new CricketPlayerDto();
        $playerDto->totalFantasyPoints = 0;
        $playerDto->totalFantasyPointsPerGame = 0;
        if ($player->cricketUnits) {
            $gamesCount = 0;
            foreach ($player->cricketUnits as $cricketUnit) {
                $unitDto = $this->updateUnitFantasyPoints($cricketUnit, $actionPoints);
                $playerDto->totalFantasyPoints += $unitDto->fantasyPoints;
                $gamesCount += $cricketUnit->unitStats()->count();
            }
            if ($gamesCount > 0) {
                $playerDto->totalFantasyPointsPerGame = $playerDto->totalFantasyPoints / $gamesCount;
            }

            $cricketPlayerService->updateFantasyPoints($player, $playerDto);
        }
    }

    private function updateUnitFantasyPoints(CricketUnit $cricketUnit, array $actionPoints): CricketUnitDto
    {
        /* @var $cricketUnitStatsService CricketUnitStatsService */
        /* @var $cricketUnitService CricketUnitService */
        $cricketUnitStatsService = resolve(CricketUnitStatsService::class);
        $cricketUnitService = resolve(CricketUnitService::class);

        $unitStats = $cricketUnitStatsService->getRealGameUnitStatsByUnitId($cricketUnit->id);
        $cricketUnitDto = $this->calcFantasyPoints($unitStats, $actionPoints, $cricketUnit);

        $cricketUnitService->storeCricketUnit($cricketUnitDto);

        return $cricketUnitDto;
    }

    private function calcFantasyPoints(
        Collection $unitStats,
        array $actionPoints,
        CricketUnit $cricketUnit
    ): CricketUnitDto {
        $unitDto = new CricketUnitDto();
        $unitDto->id = $cricketUnit->id;
        $unitDto->fantasyPoints = 0;
        $unitDto->fantasyPointsPerGame = 0;
        if ($unitStats->isNotEmpty() && $cricketUnit->position) {
            /** @var CricketUnitStats $unitStat */
            foreach ($unitStats as $unitStat) {
                $unitDto->fantasyPoints += UnitStatsHelper::calcFantasyPointsForStats(
                    $unitStat->stats,
                    $actionPoints,
                    $cricketUnit->position
                );
            }
            $unitDto->fantasyPointsPerGame = $unitDto->fantasyPoints / $unitStats->count();
        }

        return $unitDto;
    }
}
