<?php

namespace App\Services\Cricket;

use App\Helpers\ArrayHelper;
use App\Mappers\CricketUnitStatsMapper;
use App\Models\Cricket\CricketUnit;

class CalculateCricketUnitStatsTotalService
{
    public function __construct(
        private readonly CricketUnitStatsService $cricketUnitStatsService,
        private readonly CricketUnitStatsMapper $cricketUnitStatsMapper
    ) {
    }

    public function handle(CricketUnit $cricketUnit): void
    {
        $statsTotal = [];
        foreach ($cricketUnit->unitStats as $unitStat) {
            $statsTotal = ArrayHelper::sum($statsTotal, $unitStat->stats);
        }

        $this->saveTotalUnitStats($cricketUnit, $statsTotal);
    }

    private function saveTotalUnitStats(CricketUnit $cricketUnit, array $statsTotal): void
    {
        $cricketUnitStatsDto = $this->cricketUnitStatsMapper->map([
            'game_id' => null,
            'unit_id' => $cricketUnit->id,
            'player_id' => $cricketUnit->player_id,
            'team_id' => $cricketUnit->team_id,
            'stats' => $statsTotal,
        ]);

        $this->cricketUnitStatsService->storeCricketUnitStats($cricketUnitStatsDto);
    }
}
