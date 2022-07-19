<?php

namespace App\Services\Cricket;

use App\Dto\CricketGameScheduleDto;
use App\Helpers\CricketGameScheduleHelper;
use App\Models\Cricket\CricketGameSchedule;
use App\Repositories\Cricket\CricketGameScheduleRepository;

class CreateCricketGameSchedulesService
{
    public function __construct(
        private readonly ConfirmCricketGameScheduleService $confirmCricketGameScheduleService,
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository
    ) {
    }

    /**
     * @return CricketGameSchedule[]
     */
    public function handle(CricketGameScheduleDto $cricketGameScheduleDto): array
    {
        $cricketGameSchedules = $this->cricketGameScheduleRepository->getActiveByFeedIdAndLeagueId(
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

            if (CricketGameScheduleHelper::isPostponed($cricketGameSchedule->status)) {
                $cricketGameSchedule->delete();

                return [];
            }

            $this->confirmCricketGameScheduleService->handle($cricketGameSchedule);

            return [$cricketGameSchedule];
        }

        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            $cricketGameSchedule = $this->cricketGameScheduleRepository->updateOrCreate([
                'id' => $cricketGameSchedule->id,
                'feed_id' => $cricketGameScheduleDto->feedId,
                'league_id' => $cricketGameScheduleDto->leagueId,
            ], array_merge($updateData, ['is_fake' => $cricketGameSchedule->is_fake]));

            if (CricketGameScheduleHelper::isPostponed($cricketGameSchedule->status)) {
                $cricketGameSchedule->delete();

                continue;
            }

            $this->confirmCricketGameScheduleService->handle($cricketGameSchedule);
            $updatedCricketGameSchedule[] = $cricketGameSchedule;
        }

        return $updatedCricketGameSchedule;
    }
}
