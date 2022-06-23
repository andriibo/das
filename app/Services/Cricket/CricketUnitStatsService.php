<?php

namespace App\Services\Cricket;

use App\Dto\CricketUnitStatsDto;
use App\Models\Cricket\CricketUnitStats;
use App\Repositories\Cricket\CricketUnitStatsRepository;

class CricketUnitStatsService
{
    public function __construct(
        private readonly CricketUnitStatsRepository $cricketUnitStatsRepository
    ) {
    }

    public function storeCricketUnitStats(CricketUnitStatsDto $cricketUnitStatsDto): CricketUnitStats
    {
        return $this->cricketUnitStatsRepository->updateOrCreate([
            'game_schedule_id' => $cricketUnitStatsDto->gameScheduleId,
            'unit_id' => $cricketUnitStatsDto->unitId,
            'team_id' => $cricketUnitStatsDto->teamId,
        ], ['stats' => $cricketUnitStatsDto->stats]);
    }
}
