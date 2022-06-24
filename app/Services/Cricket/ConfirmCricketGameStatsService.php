<?php

namespace App\Services\Cricket;

use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Models\Cricket\CricketGameSchedule;

class ConfirmCricketGameStatsService
{
    public function __construct(private readonly CreateCricketGameStatsService $createCricketGameStatsService)
    {
    }

    public function handle(CricketGameSchedule $cricketGameSchedule)
    {
        $this->createCricketGameStatsService->handle($cricketGameSchedule);

        if (!$cricketGameSchedule->hasFinalBox()) {
            throw new \Exception('Trying to confirm unfinished Game Schedule');
        }

        $cricketGameSchedule->is_data_confirmed = IsDataConfirmedEnum::yes;
        $cricketGameSchedule->save();
    }
}
