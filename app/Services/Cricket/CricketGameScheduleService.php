<?php

namespace App\Services\Cricket;

use App\Const\CricketGameScheduleConst;
use App\Dto\CricketGameScheduleDto;
use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Models\Cricket\CricketGameSchedule;
use App\Repositories\Cricket\CricketGameScheduleRepository;
use Illuminate\Database\Eloquent\Collection;

class CricketGameScheduleService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository
    ) {
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
            'has_final_box' => $cricketGameScheduleDto->hasFinalBox->value,
            'home_team_score' => $cricketGameScheduleDto->homeTeamScore,
            'away_team_score' => $cricketGameScheduleDto->awayTeamScore,
            'is_fake' => $cricketGameScheduleDto->isFake->value,
            'is_salary_available' => $cricketGameScheduleDto->isSalaryAvailable->value,
            'feed_type' => $cricketGameScheduleDto->feedType->name,
            'status' => $cricketGameScheduleDto->status?->value,
            'type' => $cricketGameScheduleDto->type->value,
        ]);
    }

    public function updateDataConfirmed(CricketGameSchedule $cricketGameSchedule): void
    {
        $gameConfirmTime = strtotime($cricketGameSchedule->updated_at) + CricketGameScheduleConst::CONFIRM_STATS_DELAY;
        if (
            $cricketGameSchedule->has_final_box == HasFinalBoxEnum::yes->value
            && $cricketGameSchedule->is_data_confirmed == IsDataConfirmedEnum::no->value
            && $gameConfirmTime < time()
        ) {
            $cricketGameSchedule->is_data_confirmed = IsDataConfirmedEnum::yes->value;
            $cricketGameSchedule->save();
        }
    }
}
