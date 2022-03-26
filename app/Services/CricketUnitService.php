<?php

namespace App\Services;

use App\Dto\CricketUnitDto;
use App\Models\CricketUnit;
use App\Repositories\CricketUnitRepository;

class CricketUnitService
{
    public function __construct(
        private readonly CricketUnitRepository $cricketUnitRepository
    ) {
    }

    public function storeCricketUnit(CricketUnitDto $cricketUnitDto): CricketUnit
    {
        return $this->cricketUnitRepository->updateOrCreate([
            'cricket_player_id' => $cricketUnitDto->cricketPlayerId,
            'cricket_team_id' => $cricketUnitDto->cricketTeamId,
        ], ['position' => $cricketUnitDto->position?->value]);
    }
}
