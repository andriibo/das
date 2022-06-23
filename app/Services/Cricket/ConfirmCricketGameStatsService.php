<?php

namespace App\Services\Cricket;

use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Models\Cricket\CricketGameSchedule;

class ConfirmCricketGameStatsService
{
    public function __construct(private readonly CreateGameStatsService $createGameStatsService)
    {
    }

    public function handle(CricketGameSchedule $cricketGameSchedule)
    {
        $this->createGameStatsService->handle($cricketGameSchedule);

        if ($cricketGameSchedule->has_final_box == HasFinalBoxEnum::no->value) {
            throw new \Exception('Trying to confirm unfinished Game Schedule');
        }

        $cricketGameSchedule->is_data_confirmed = IsDataConfirmedEnum::yes;
        $cricketGameSchedule->save();
    }
}
