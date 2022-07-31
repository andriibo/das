<?php

namespace App\Services\Cricket;

use App\Helpers\CricketGameScheduleHelper;
use App\Repositories\Cricket\CricketGameScheduleRepository;

class UnconfirmedGameSchedulesService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository,
        private readonly CreateCricketGameStatsService $createCricketGameStatsService,
        private readonly ConfirmCricketGameScheduleService $confirmCricketGameScheduleService
    ) {
    }

    public function handle(int $leagueId)
    {
        $cricketGameSchedules = $this->cricketGameScheduleRepository->getUnconfirmed($leagueId);
        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            if (CricketGameScheduleHelper::isPresentedInActiveContests($cricketGameSchedule)) {
                continue;
            }

            if (!$cricketGameSchedule->hasFinalBox()) {
                $this->createCricketGameStatsService->handle($cricketGameSchedule);
            } elseif (CricketGameScheduleHelper::canConfirmData($cricketGameSchedule)) {
                $this->createCricketGameStatsService->handle($cricketGameSchedule);
                $this->confirmCricketGameScheduleService->handle($cricketGameSchedule);
            }
        }
    }
}
