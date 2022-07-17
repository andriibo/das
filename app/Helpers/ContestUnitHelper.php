<?php

namespace App\Helpers;

use App\Models\Contests\ContestUnit;
use App\Repositories\Cricket\CricketUnitStatsRepository;
use Illuminate\Support\Collection;

class ContestUnitHelper
{
    public static function calculateScore(ContestUnit $contestUnit, Collection $actionPoints): float
    {
        $cricketUnitStatsRepository = new CricketUnitStatsRepository();
        $gameScheduleIds = $contestUnit->contest->cricketGameSchedules->pluck('id')->toArray();
        $cricketUnitStats = $cricketUnitStatsRepository->getByParams($contestUnit->unit_id, $gameScheduleIds);
        $score = 0;
        foreach ($cricketUnitStats as $cricketUnitStat) {
            $score += CricketUnitHelper::calculateScore($contestUnit->cricketUnit, $cricketUnitStat->stats, $actionPoints);
        }

        return $score;
    }
}
