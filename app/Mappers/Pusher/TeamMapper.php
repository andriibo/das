<?php

namespace App\Mappers\Pusher;

use App\Models\Cricket\CricketTeam;
use App\Models\Soccer\SoccerTeam;
use Pusher\Dto\TeamDto;

class TeamMapper
{
    public function map(SoccerTeam|CricketTeam $team): TeamDto
    {
        $teamDto = new TeamDto();

        $teamDto->id = $team->id;
        $teamDto->name = $team->name;
        $teamDto->alias = $team->alias;

        return $teamDto;
    }
}
