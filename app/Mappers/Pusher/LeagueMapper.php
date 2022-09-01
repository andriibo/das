<?php

namespace App\Mappers\Pusher;

use App\Models\League;
use Pusher\Dto\LeagueDto;

class LeagueMapper
{
    public function map(League $league): LeagueDto
    {
        $leagueDto = new LeagueDto();

        $leagueDto->id = $league->id;
        $leagueDto->name = $league->name;
        $leagueDto->alias = $league->alias;
        $leagueDto->sportId = $league->sport_id;

        return $leagueDto;
    }
}
