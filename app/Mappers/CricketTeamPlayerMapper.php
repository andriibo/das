<?php

namespace App\Mappers;

use App\Dto\CricketTeamPlayerDto;
use App\Enums\CricketTeamPlayerPlayingRoleEnum;

class CricketTeamPlayerMapper
{
    public function map(array $data): CricketTeamPlayerDto
    {
        $cricketTeamPlayerDto = new CricketTeamPlayerDto();

        $cricketTeamPlayerDto->cricketTeamId = $data['team_id'];
        $cricketTeamPlayerDto->cricketPlayerId = $data['player_id'];
        $cricketTeamPlayerDto->playingRole = CricketTeamPlayerPlayingRoleEnum::tryFrom($data['role']);

        return $cricketTeamPlayerDto;
    }
}
