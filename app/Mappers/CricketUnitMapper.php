<?php

namespace App\Mappers;

use App\Dto\CricketUnitDto;
use App\Enums\CricketUnitPositionEnum;

class CricketUnitMapper
{
    public function map(array $data): CricketUnitDto
    {
        $cricketTeamPlayerDto = new CricketUnitDto();

        $cricketTeamPlayerDto->cricketTeamId = $data['team_id'];
        $cricketTeamPlayerDto->cricketPlayerId = $data['player_id'];
        $cricketTeamPlayerDto->position = CricketUnitPositionEnum::tryFrom($data['position']);

        return $cricketTeamPlayerDto;
    }
}
