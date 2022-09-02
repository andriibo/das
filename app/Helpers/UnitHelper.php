<?php

namespace App\Helpers;

use App\Models\ActionPoint;
use App\Models\Cricket\CricketUnit;
use App\Models\Soccer\SoccerUnit;
use Illuminate\Support\Collection;

class UnitHelper
{
    /**
     * @param ActionPoint[]|Collection $actionPoints
     */
    public static function calculateScore(CricketUnit|SoccerUnit $unit, array $stats, Collection $actionPoints): float
    {
        $score = 0;
        foreach ($actionPoints as $actionPoint) {
            if (isset($stats[$actionPoint->name], $actionPoint->values[$unit->position])) {
                $score += $stats[$actionPoint->name] * $actionPoint->values[$unit->position];
            }
        }

        return round($score, 2);
    }
}
