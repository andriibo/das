<?php

namespace App\Mappers\Nodejs;

use App\Models\Cricket\CricketTeam;
use App\Models\Soccer\SoccerTeam;
use NodeJsClient\Dto\TeamDto;

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
