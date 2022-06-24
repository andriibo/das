<?php

namespace App\Helpers;

use App\Enums\Contests\StatusEnum;
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
}
