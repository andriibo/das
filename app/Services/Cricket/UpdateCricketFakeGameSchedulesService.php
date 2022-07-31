<?php

namespace App\Services\Cricket;

use App\Dto\CricketGameScheduleDto;
use App\Repositories\Cricket\CricketGameScheduleRepository;

class UpdateCricketFakeGameSchedulesService
{
    public function __construct(private readonly CricketGameScheduleRepository $cricketGameScheduleRepository)
    {
    }

    public function handle(CricketGameScheduleDto $cricketGameScheduleDto): void
    {
        $cricketGameSchedules = $this->cricketGameScheduleRepository->getFakeCricketGameSchedules(
            $cricketGameScheduleDto->feedId,
            $cricketGameScheduleDto->leagueId
        );

        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            $cricketGameSchedule->home_team_score = $cricketGameScheduleDto->homeTeamScore;
            $cricketGameSchedule->away_team_score = $cricketGameScheduleDto->awayTeamScore;
            $cricketGameSchedule->status = $cricketGameScheduleDto->status;
            $cricketGameSchedule->type = $cricketGameScheduleDto->type;
            $cricketGameSchedule->save();
        }
    }
}
