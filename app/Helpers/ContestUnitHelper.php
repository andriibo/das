<?php

namespace App\Helpers;

use App\Models\Contests\ContestUnit;
use App\Repositories\Cricket\CricketUnitStatsRepository;

class ContestUnitHelper
{
    public static function calculateScore(ContestUnit $contestUnit, array $actionPoints = []): float
    {
        $cricketUnitStatsRepository = new CricketUnitStatsRepository();
        $gameScheduleIds = $contestUnit->contest->cricketGameSchedules->pluck('game_schedule_id')->toArray();
        $cricketUnitStats = $cricketUnitStatsRepository->getByParams($contestUnit->unit_id, $gameScheduleIds);
        $score = 0;
        foreach ($cricketUnitStats as $cricketUnitStat) {
            $score += CricketUnitHelper::calculateScore($contestUnit->cricketUnit, $cricketUnitStat, $actionPoints);
        }

        return $score;
    }
}
