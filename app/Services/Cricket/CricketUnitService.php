<?php

namespace App\Services\Cricket;

use App\Dto\CricketUnitDto;
use App\Models\Cricket\CricketUnit;
use App\Repositories\Cricket\CricketUnitRepository;

class CricketUnitService
{
    public function __construct(
        private readonly CricketUnitRepository $cricketUnitRepository
    ) {
    }

    public function storeCricketUnit(CricketUnitDto $cricketUnitDto): CricketUnit
    {
        return $this->cricketUnitRepository->updateOrCreate([
            'player_id' => $cricketUnitDto->playerId,
            'team_id' => $cricketUnitDto->teamId,
            'position' => $cricketUnitDto->position->value,
        ], [
            'fantasy_points' => $cricketUnitDto->fantasyPoints,
            'fantasy_points_per_game' => $cricketUnitDto->fantasyPointsPerGame,
        ]);
    }
}
