<?php

namespace App\Helpers;

use App\Models\Contests\ContestUnit;

class ContestUnitHelper
{
    public static function calculateScore(ContestUnit $contestUnit, array $actionPoints = []): float
    {
        $contest = $contestUnit->contest;
        $gameIds = ArrayHelper::getColumn($contest->contestGames, 'game_id');
        $score = 0;
        foreach ($gameIds as $gameId) {
            foreach ($contestUnit->getStats($gameId) as $stats) {
                $score += $contestUnit->unit->calcScore($stats->stats, $actionPoints);
            }
        }

        return $score;
    }
}
