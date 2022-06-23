<?php

namespace App\Services\Cricket;

use App\Repositories\Cricket\CricketGameScheduleRepository;

class ConfirmHistoricalCricketGameSchedulesService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository,
        private readonly ConfirmCricketGameStatsService $confirmCricketGameStatsService
    ) {
    }

    public function handle(int $leagueId)
    {
        $cricketGameSchedules = $this->cricketGameScheduleRepository->getHistorical($leagueId);

        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            if ($cricketGameSchedule->has_final_box == 1) {
                $this->confirmCricketGameStatsService->handle($cricketGameSchedule);
            }
        }
    }
}
