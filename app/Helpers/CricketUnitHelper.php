<?php

namespace App\Helpers;

use App\Models\ActionPoint;
use App\Models\Cricket\CricketUnit;
use Illuminate\Support\Collection;

class CricketUnitHelper
{
    /**
     * @param ActionPoint[]|Collection $actionPoints
     */
    public static function calculateScore(CricketUnit $cricketUnit, array $stats, Collection $actionPoints): float
    {
        $score = 0;
        foreach ($actionPoints as $actionPoint) {
            if (isset($stats[$actionPoint->name], $actionPoint->values[$cricketUnit->position])) {
                $score += $stats[$actionPoint->name] * $actionPoint->values[$cricketUnit->position];
            }
        }

        return round($score, 2);
    }
}
