<?php

namespace App\Services;

use App\Dto\CricketUnitDto;
use App\Models\CricketUnit;
use App\Repositories\CricketUnitRepository;
use Illuminate\Database\Eloquent\Collection;

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
        ], [
            'position' => $cricketUnitDto->position?->value,
            'fantasy_points' => $cricketUnitDto->fantasyPoints,
            'fantasy_points_per_game' => $cricketUnitDto->fantasyPointsPerGame,
        ]);
    }

    public function getCricketUnits(): Collection
    {
        return $this->cricketUnitRepository->getList();
    }
}
