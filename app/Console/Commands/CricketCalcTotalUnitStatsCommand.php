<?php

namespace App\Console\Commands;

use App\Helpers\ArrayHelper;
use App\Mappers\CricketUnitStatsMapper;
use App\Models\CricketUnit;
use App\Services\CricketUnitService;
use App\Services\CricketUnitStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketCalcTotalUnitStatsCommand extends Command
{
    protected $signature = 'cricket:calc-total-unit-stats';

    protected $description = 'Calculate total unit stats';

    public function handle(CricketUnitService $cricketUnitService): void
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketUnits = $cricketUnitService->getCricketUnits();

        /** @var CricketUnit $cricketUnit */
        foreach ($cricketUnits as $cricketUnit) {
            $statsTotal = $this->calcCricketUnitTotalStats($cricketUnit);
            $this->saveTotalUnitStats($cricketUnit, $statsTotal);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function calcCricketUnitTotalStats(CricketUnit $cricketUnit): array
    {
        $stats = [];
        foreach ($cricketUnit->unitStats as $unitStat) {
            $stats = ArrayHelper::sum($stats, $unitStat->stats);
        }

        return $stats;
    }

    private function saveTotalUnitStats(CricketUnit $cricketUnit, array $statsTotal): void
    {
        $cricketUnitStatsService = resolve(CricketUnitStatsService::class);
        $cricketUnitStatsMapper = resolve(CricketUnitStatsMapper::class);
        $cricketUnitStatsDto = $cricketUnitStatsMapper->map([
            'game_id' => null,
            'unit_id' => $cricketUnit->id,
            'player_id' => $cricketUnit->player_id,
            'team_id' => $cricketUnit->team_id,
            'stats' => $statsTotal,
        ]);
        $cricketUnitStatsService->storeCricketUnitStats($cricketUnitStatsDto);
    }
}
