<?php

namespace App\Services\Cricket;

use App\Const\CricketGameScheduleConst;
use App\Helpers\CricketGameScheduleHelper;
use App\Repositories\Cricket\CricketGameScheduleRepository;

class UnconfirmedGameSchedulesService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository,
        private readonly CreateCricketGameStatsService $createCricketGameStatsService,
        private readonly ConfirmCricketGameStatsService $confirmCricketGameStatsService
    ) {
    }

    public function handle(int $leagueId)
    {
        $cricketGameSchedules = $this->cricketGameScheduleRepository->getHistorical($leagueId);

        foreach ($cricketGameSchedules as $cricketGameSchedule) {
            if (CricketGameScheduleHelper::isPresentedInActiveContests($cricketGameSchedule)) {
                continue;
            }

            if (!$cricketGameSchedule->hasFinalBox()) {
                $this->createCricketGameStatsService->handle($cricketGameSchedule);
            } elseif ($cricketGameSchedule->updated_at < date('Y-m-d H:i:s', time() - CricketGameScheduleConst::CONFIRM_STATS_DELAY)) {
                $this->confirmCricketGameStatsService->handle($cricketGameSchedule);
            }
        }
    }
}
