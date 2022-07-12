<?php

namespace App\Services\Cricket;

use App\Const\CricketGameScheduleConst;
use App\Dto\CricketGameScheduleDto;
use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Models\Cricket\CricketGameSchedule;
use App\Repositories\Cricket\CricketGameScheduleRepository;

class CricketGameScheduleService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository
    ) {
    }

    /**
     * @return CricketGameSchedule[]
     */
    public function storeCricketGameSchedules(CricketGameScheduleDto $cricketGameScheduleDto): array
    {
        $cricketGameSchedules = $this->cricketGameScheduleRepository->getByFeedIdAndLeagueId(
            $cricketGameScheduleDto->feedId,
            $cricketGameScheduleDto->leagueId
        );

        $updateData = [
            'home_team_id' => $cricketGameScheduleDto->homeTeamId,
            'away_team_id' => $cricketGameScheduleDto->awayTeamId,
            'game_date' => $cricketGameScheduleDto->gameDate,
            'has_final_box' => $cricketGameScheduleDto->hasFinalBox->value,
            'home_team_score' => $cricketGameScheduleDto->homeTeamScore,
            'away_team_score' => $cricketGameScheduleDto->awayTeamScore,
            'is_salary_available' => $cricketGameScheduleDto->isSalaryAvailable->value,
            'feed_type' => $cricketGameScheduleDto->feedType->name,
            'status' => $cricketGameScheduleDto->status?->value,
            'type' => $cricketGameScheduleDto->type->value,
        ];

        if ($cricketGameSchedules->isEmpty()) {
            $cricketGameSchedule = $this->cricketGameScheduleRepository->updateOrCreate([
                'feed_id' => $cricketGameScheduleDto->feedId,
                'league_id' => $cricketGameScheduleDto->leagueId,
            ], array_merge($updateData, ['is_fake' => $cricketGameScheduleDto->isFake->value]));

            return [$cricketGameSchedule];
        }

        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            $updatedCricketGameSchedule[] = $this->cricketGameScheduleRepository->updateOrCreate([
                'id' => $cricketGameSchedule->id,
                'feed_id' => $cricketGameScheduleDto->feedId,
                'league_id' => $cricketGameScheduleDto->leagueId,
            ], array_merge($updateData, ['is_fake' => $cricketGameSchedule->is_fake]));
        }

        return $updatedCricketGameSchedule;
    }

    /**
     * @param $cricketGameSchedules CricketGameSchedule[]
     */
    public function confirmGameSchedules(array $cricketGameSchedules): void
    {
        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            $gameConfirmTime = strtotime($cricketGameSchedule->updated_at) + CricketGameScheduleConst::CONFIRM_STATS_DELAY;
            if (
                $cricketGameSchedule->hasFinalBox()
                && !$cricketGameSchedule->isDataConfirmed()
                && $gameConfirmTime < time()
            ) {
                $cricketGameSchedule->is_data_confirmed = IsDataConfirmedEnum::yes->value;
                $cricketGameSchedule->save();
            }
        }
    }
}
