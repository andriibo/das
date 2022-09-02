<?php

namespace App\Helpers;

use App\Models\ActionPoint;
use App\Models\Soccer\SoccerUnit;
use Illuminate\Support\Collection;

class SoccerUnitHelper
{
    /**
     * @param ActionPoint[]|Collection $actionPoints
     */
    public static function calculateScore(SoccerUnit $soccerUnit, array $stats, Collection $actionPoints): float
    {
        $score = 0;
        foreach ($actionPoints as $actionPoint) {
            if (isset($stats[$actionPoint->name], $actionPoint->values[$soccerUnit->position])) {
                $score += $stats[$actionPoint->name] * $actionPoint->values[$soccerUnit->position];
            }
        }

        return round($score, 2);
    }
}
