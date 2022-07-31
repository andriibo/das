<?php

namespace App\Services\Cricket;

use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Helpers\CricketGameScheduleHelper;
use App\Models\Cricket\CricketGameSchedule;

class ConfirmCricketGameScheduleService
{
    public function handle(CricketGameSchedule &$cricketGameSchedule): void
    {
        if (CricketGameScheduleHelper::canConfirmData($cricketGameSchedule)) {
            $cricketGameSchedule->is_data_confirmed = IsDataConfirmedEnum::yes;
            $cricketGameSchedule->save();
        }
    }
}
