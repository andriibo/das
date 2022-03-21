<?php

namespace App\Dto;

use App\Enums\CricketTeamPlayerPlayingRoleEnum;

class CricketTeamPlayerDto
{
    public int $id;
    public int $cricketTeamId;
    public int $cricketPlayerId;
    public ?CricketTeamPlayerPlayingRoleEnum $playingRole;
}
