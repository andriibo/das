<?php

namespace App\Mappers;

use App\Dto\CricketUnitDto;
use App\Services\Cricket\GetCricketUnitPositionService;

class CricketUnitMapper
{
    public function __construct(private readonly GetCricketUnitPositionService $getCricketUnitPositionService)
    {
    }

    public function map(array $data): CricketUnitDto
    {
        $cricketTeamPlayerDto = new CricketUnitDto();

        $cricketTeamPlayerDto->teamId = $data['team_id'];
        $cricketTeamPlayerDto->playerId = $data['player_id'];
        $cricketTeamPlayerDto->position = $this->getCricketUnitPositionService->handle($data['position']);
        $cricketTeamPlayerDto->fantasyPoints = $data['fantasy_points'] ?? null;
        $cricketTeamPlayerDto->fantasyPointsPerGame = $data['fantasy_points_per_game'] ?? null;

        return $cricketTeamPlayerDto;
    }
}
