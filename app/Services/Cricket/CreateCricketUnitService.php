<?php

namespace App\Services\Cricket;

use App\Mappers\CricketUnitMapper;
use App\Models\Cricket\CricketPlayer;

class CreateCricketUnitService
{
    public function __construct(private readonly CricketUnitService $cricketUnitService)
    {
    }

    public function handle(CricketPlayer $cricketPlayer, int $teamId, string $position): void
    {
        $cricketUnitMapper = new CricketUnitMapper();

        $cricketUnitDto = $cricketUnitMapper->map([
            'player_id' => $cricketPlayer->id,
            'team_id' => $teamId,
            'position' => $position,
        ]);

        $this->cricketUnitService->storeCricketUnit($cricketUnitDto);
    }
}
