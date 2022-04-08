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

    /**
     * @return Collection|CricketUnitStats[]
     */
    public function getCricketUnitStats(): Collection
    {
        return $this->cricketUnitStatsRepository->getList();
    }

    public function storeCricketUnitStats(CricketUnitStatsDto $cricketUnitStatsDto): CricketUnitStats
    {
        return $this->cricketUnitStatsRepository->updateOrCreate([
            'game_schedule_id' => $cricketUnitStatsDto->gameScheduleId,
            'player_id' => $cricketUnitStatsDto->playerId,
            'team_id' => $cricketUnitStatsDto->teamId,
        ], ['raw_stats' => $cricketUnitStatsDto->rawStats]);
    }
}
