<?php

namespace App\Services;

use App\Dto\CricketUnitStatDto;
use App\Models\CricketUnitStat;
use App\Repositories\CricketUnitStatRepository;

class CricketUnitStatService
{
    public function __construct(
        private readonly CricketUnitStatRepository $cricketUnitStatRepository
    ) {
    }

    public function storeCricketUnitStat(CricketUnitStatDto $cricketUnitStatDto): CricketUnitStat
    {
        return $this->cricketUnitStatRepository->updateOrCreate([
            'game_schedule_id' => $cricketUnitStatDto->gameScheduleId,
            'player_id' => $cricketUnitStatDto->playerId,
            'team_id' => $cricketUnitStatDto->teamId,
        ], ['raw_stat' => $cricketUnitStatDto->rawStat]);
    }
}
