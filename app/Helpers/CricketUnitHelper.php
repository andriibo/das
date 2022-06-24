<?php

namespace App\Helpers;

use App\Models\Cricket\CricketUnit;

class CricketUnitHelper
{
    public static function calculateScore(CricketUnit $cricketUnit, array $stats, array $actionPoints): float
    {
        $score = 0;
        foreach ($actionPoints as $name => $values) {
            if (isset($stats[$name], $values[$cricketUnit->position])) {
                $score += $stats[$name] * $values[$cricketUnit->position];
            }
        }

        return round($score, 2);
    }
}
