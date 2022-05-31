<?php

namespace App\Helpers;

class UnitStatsHelper
{
    public static function calcFantasyPointsForStats(array $stats, array $actionPoints, string $position): float
    {
        $score = 0;

        foreach ($actionPoints as $name => $values) {
            if (isset($stats[$name], $values[$position])) {
                $score += $stats[$name] * $values[$position];
            }
        }

        return round($score, 2);
    }
}
