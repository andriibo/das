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

    /**
     * Get difference between array values.
     */
    public static function delta(array $ar1, array $ar2): array
    {
        $delta = [];
        foreach ($ar1 as $key => $value) {
            $delta[$key] = isset($ar2[$key]) ? $value - $ar2[$key] : $value;
        }

        return $delta;
    }
}
