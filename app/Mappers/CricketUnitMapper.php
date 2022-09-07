<?php

namespace App\Mappers;

use App\Dto\CricketUnitDto;
use App\Services\Cricket\GetCricketPositionEnumService;

class CricketUnitMapper
{
    public function __construct(private readonly GetCricketPositionEnumService $getCricketPositionEnumService)
    {
    }

    public function map(array $data): CricketUnitDto
    {
        $cricketTeamPlayerDto = new CricketUnitDto();

        $cricketTeamPlayerDto->teamId = $data['team_id'];
        $cricketTeamPlayerDto->playerId = $data['player_id'];
        $cricketTeamPlayerDto->position = $this->getCricketPositionEnumService->handle($data['position']);
        $cricketTeamPlayerDto->fantasyPoints = $data['fantasy_points'] ?? null;
        $cricketTeamPlayerDto->fantasyPointsPerGame = $data['fantasy_points_per_game'] ?? null;

        return $cricketTeamPlayerDto;
    }
}
