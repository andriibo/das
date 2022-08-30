<?php

namespace App\Helpers;

use App\Models\Contests\ContestUnit;
use App\Repositories\Cricket\CricketUnitStatsRepository;
use App\Repositories\Soccer\SoccerUnitStatsRepository;
use Illuminate\Support\Collection;

class ContestUnitHelper
{
    public static function calculateScore(ContestUnit $contestUnit, Collection $actionPoints): float
    {
        if ($contestUnit->isSportCricket()) {
            $cricketUnitStatsRepository = new CricketUnitStatsRepository();
            $gameScheduleIds = $contestUnit->contest->cricketGameSchedules->pluck('id')->toArray();
            $unitStats = $cricketUnitStatsRepository->getByParams($contestUnit->unit_id, $gameScheduleIds);
            $gameUnit = $contestUnit->cricketUnit;
        }

        if ($contestUnit->isSportSoccer()) {
            $soccerUnitStatsRepository = new SoccerUnitStatsRepository();
            $gameScheduleIds = $contestUnit->contest->soccerGameSchedules->pluck('id')->toArray();
            $unitStats = $soccerUnitStatsRepository->getByParams($contestUnit->unit_id, $gameScheduleIds);
            $gameUnit = $contestUnit->soccerUnit;
        }

        $score = 0;
        foreach ($unitStats as $unitStat) {
            $score += UnitHelper::calculateScore($gameUnit, $unitStat->stats, $actionPoints);
        }

        return $score;
    }
}
