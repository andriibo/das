<?php

namespace App\Services\Cricket;

use App\Dto\CricketGameScheduleDto;
use App\Models\Cricket\CricketGameSchedule;
use App\Repositories\Cricket\CricketGameScheduleRepository;

class CreateCricketGameScheduleService
{
    public function __construct(private readonly CricketGameScheduleRepository $cricketGameScheduleRepository)
    {
    }

    public function handle(CricketGameScheduleDto $cricketGameScheduleDto): CricketGameSchedule
    {
        return $this->cricketGameScheduleRepository->updateOrCreate([
            'feed_id' => $cricketGameScheduleDto->feedId,
            'league_id' => $cricketGameScheduleDto->leagueId,
        ], [
            'home_team_id' => $cricketGameScheduleDto->homeTeamId,
            'away_team_id' => $cricketGameScheduleDto->awayTeamId,
            'game_date' => $cricketGameScheduleDto->gameDate,
            'has_final_box' => $cricketGameScheduleDto->hasFinalBox->value,
            'home_team_score' => $cricketGameScheduleDto->homeTeamScore,
            'away_team_score' => $cricketGameScheduleDto->awayTeamScore,
            'is_salary_available' => $cricketGameScheduleDto->isSalaryAvailable->value,
            'feed_type' => $cricketGameScheduleDto->feedType->name,
            'status' => $cricketGameScheduleDto->status->value,
            'type' => $cricketGameScheduleDto->type->value,
        ]);
    }
}
