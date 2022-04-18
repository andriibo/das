<?php

namespace App\Services;

use App\Const\CricketGameScheduleConst;
use App\Dto\CricketGameScheduleDto;
use App\Models\CricketGameSchedule;
use App\Repositories\CricketGameScheduleRepository;
use Illuminate\Database\Eloquent\Collection;

class CricketGameScheduleService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository
    ) {
    }

    public function getCricketGameScheduleByFeedId(string $feedId): CricketGameSchedule
    {
        return $this->cricketGameScheduleRepository->getByFeedId($feedId);
    }

    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getCricketGameSchedules(): Collection
    {
        return $this->cricketGameScheduleRepository->getList();
    }

    public function storeCricketGameSchedule(CricketGameScheduleDto $cricketGameScheduleDto): CricketGameSchedule
    {
        return $this->cricketGameScheduleRepository->updateOrCreate([
            'feed_id' => $cricketGameScheduleDto->feedId,
            'league_id' => $cricketGameScheduleDto->leagueId,
        ], [
            'home_team_id' => $cricketGameScheduleDto->homeTeamId,
            'away_team_id' => $cricketGameScheduleDto->awayTeamId,
            'game_date' => $cricketGameScheduleDto->gameDate,
            'has_final_box' => $cricketGameScheduleDto->hasFinalBox,
            'home_team_score' => $cricketGameScheduleDto->homeTeamScore,
            'away_team_score' => $cricketGameScheduleDto->awayTeamScore,
            'is_fake' => $cricketGameScheduleDto->isFake,
            'is_salary_available' => $cricketGameScheduleDto->isSalaryAvailable,
            'feed_type' => $cricketGameScheduleDto->feedType->name,
            'status' => $cricketGameScheduleDto->status?->value,
            'type' => $cricketGameScheduleDto->type->value,
        ]);
    }

    public function updateDataConfirmed(CricketGameSchedule $cricketGameSchedule): void
    {
        $gameConfirmTime = strtotime($cricketGameSchedule->updated_at) + CricketGameScheduleConst::CONFIRM_STATS_DELAY;
        if (
            $cricketGameSchedule->has_final_box == CricketGameScheduleConst::HAS_FINAL_BOX
            && $cricketGameSchedule->is_data_confirmed == CricketGameScheduleConst::IS_NOT_DATA_CONFIRMED
            && $gameConfirmTime < time()
        ) {
            $cricketGameSchedule->is_data_confirmed = CricketGameScheduleConst::IS_DATA_CONFIRMED;
            $cricketGameSchedule->save();
        }
    }
}
