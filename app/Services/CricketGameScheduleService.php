<?php

namespace App\Services;

use App\Dto\CricketGameScheduleDto;
use App\Models\CricketGameSchedule;
use App\Repositories\CricketGameScheduleRepository;

class CricketGameScheduleService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository
    ) {
    }

    public function storeCricketGameSchedule(CricketGameScheduleDto $cricketGameScheduleDto): CricketGameSchedule
    {
        return $this->cricketGameScheduleRepository->updateOrCreate([
            'feed_id' => $cricketGameScheduleDto->feedId,
            'league_id' => $cricketGameScheduleDto->leagueId,
        ], [
            'home_cricket_team_id' => $cricketGameScheduleDto->homeCricketTeamId,
            'away_cricket_team_id' => $cricketGameScheduleDto->awayCricketTeamId,
            'game_date' => $cricketGameScheduleDto->gameDate,
            'has_final_box' => $cricketGameScheduleDto->hasFinalBox,
            'is_data_confirmed' => $cricketGameScheduleDto->isDataConfirmed,
            'home_cricket_team_score' => $cricketGameScheduleDto->homeCricketTeamScore,
            'away_cricket_team_score' => $cricketGameScheduleDto->awayCricketTeamScore,
            'date_updated' => $cricketGameScheduleDto->dateUpdated,
            'is_fake' => $cricketGameScheduleDto->isFake,
            'is_salary_available' => $cricketGameScheduleDto->isSalaryAvailable,
            'feed_type' => $cricketGameScheduleDto->feedType->name,
            'status' => $cricketGameScheduleDto->status->value,
            'type' => $cricketGameScheduleDto->type->value,
        ]);
    }
}
