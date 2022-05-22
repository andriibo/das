<?php

namespace App\Services;

use App\Dto\CricketGameStatsDto;
use App\Models\CricketGameStats;
use App\Repositories\CricketGameStatsRepository;

class CricketGameStatsService
{
    public function __construct(
        private readonly CricketGameStatsRepository $cricketGameStatsRepository
    ) {
    }

    public function storeCricketGameStats(CricketGameStatsDto $cricketGameStatsDto): CricketGameStats
    {
        return $this->cricketGameStatsRepository->updateOrCreate([
            'game_schedule_id' => $cricketGameStatsDto->gameScheduleId,
        ], [
            'raw_stats' => $cricketGameStatsDto->rawStats,
        ]);
    }
}
