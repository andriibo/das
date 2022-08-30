<?php

namespace App\Services;

use App\Models\Contests\ContestUnit;

class GetCricketUnitStatsService
{
    public function handle(ContestUnit $contestUnit)
    {
        if ($contestUnit->isSportCricket()) {
        }

        if ($contestUnit->isSportSoccer()) {
        }
    }
}
