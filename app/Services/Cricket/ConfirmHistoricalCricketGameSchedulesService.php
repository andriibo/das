<?php

namespace App\Services\Cricket;

use App\Repositories\Cricket\CricketGameScheduleRepository;

class ConfirmHistoricalCricketGameSchedulesService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository,
        private readonly CreateCricketGameStatsService $createCricketGameStatsService,
        private readonly ConfirmCricketGameScheduleService $confirmCricketGameScheduleService
    ) {
    }

    public function handle(int $leagueId)
    {
        $cricketGameSchedules = $this->cricketGameScheduleRepository->getHistorical($leagueId);

        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            if ($cricketGameSchedule->hasFinalBox()) {
                $this->createCricketGameStatsService->handle($cricketGameSchedule);
                $this->confirmCricketGameScheduleService->handle($cricketGameSchedule);
            }
        }
    }
}
