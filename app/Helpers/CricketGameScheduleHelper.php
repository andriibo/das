<?php

namespace App\Helpers;

use App\Const\CricketGameScheduleConst;
use App\Enums\Contests\StatusEnum;
use App\Enums\CricketGameSchedule\StatusEnum as CricketGameScheduleStatus;
use App\Models\Cricket\CricketGameSchedule;

class CricketGameScheduleHelper
{
    public static function isPresentedInActiveContests(CricketGameSchedule $cricketGameSchedule): bool
    {
        foreach ($cricketGameSchedule->contestGames as $contestGame) {
            if (
                $contestGame->contest && in_array($contestGame->contest->status, [
                    StatusEnum::ready->value,
                    StatusEnum::started->value,
                    StatusEnum::finished->value,
                ])
            ) {
                return true;
            }
        }

        return false;
    }

    public static function isStatusLive(?string $status): bool
    {
        return in_array($status, [
            CricketGameScheduleStatus::inProgress->value,
            CricketGameScheduleStatus::finished->value,
        ]);
    }

    public static function isPostponed(?string $status): bool
    {
        return $status == CricketGameScheduleStatus::stumps->value;
    }

    public static function canConfirmData(CricketGameSchedule $cricketGameSchedule): bool
    {
        if (!$cricketGameSchedule->hasFinalBox() || $cricketGameSchedule->isDataConfirmed()) {
            return false;
        }

        $confirmTime = strtotime($cricketGameSchedule->updated_at) + CricketGameScheduleConst::CONFIRM_STATS_DELAY;

        return $confirmTime < time();
    }
}
