<?php

namespace App\Services;

use App\Dto\CricketUnitStatsDto;
use App\Models\CricketUnitStats;
use App\Repositories\CricketUnitStatsRepository;
use Illuminate\Database\Eloquent\Collection;

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

    public function getRealGameUnitStatsByUnitId(int $unitId): Collection
    {
        return $this->cricketUnitStatsRepository->getRealGameUnitStatsByUnitId($unitId);
    }
}
