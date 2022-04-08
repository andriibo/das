<?php

namespace App\Mappers;

use App\Dto\CricketUnitDto;
use App\Enums\CricketUnitPositionEnum;

class CricketUnitMapper
{
    public function map(array $data): CricketUnitDto
    {
        $cricketTeamPlayerDto = new CricketUnitDto();

        $cricketTeamPlayerDto->teamId = $data['team_id'];
        $cricketTeamPlayerDto->playerId = $data['player_id'];
        $cricketTeamPlayerDto->position = CricketUnitPositionEnum::tryFrom($data['position']);

        return $cricketTeamPlayerDto;
    }
}
