<?php

namespace App\Mappers\Pusher;

use App\Helpers\DateHelper;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\Soccer\SoccerGameSchedule;
use Pusher\Dto\GameScheduleDto;

class GameScheduleMapper
{
    public function __construct(private readonly TeamMapper $teamMapper)
    {
    }

    public function map(CricketGameSchedule|SoccerGameSchedule $gameSchedule): GameScheduleDto
    {
        $gameScheduleDto = new GameScheduleDto();

        $gameScheduleDto->id = $gameSchedule->id;
        $gameScheduleDto->startDate = DateHelper::dateFormatMs($gameSchedule->game_date);
        $gameScheduleDto->awayTeamScore = $gameSchedule->away_team_score;
        $gameScheduleDto->homeTeamScore = $gameSchedule->home_team_score;
        $gameScheduleDto->awayTeam = $this->teamMapper->map($gameSchedule->awayTeam);
        $gameScheduleDto->homeTeam = $this->teamMapper->map($gameSchedule->homeTeam);

        return $gameScheduleDto;
    }
}
