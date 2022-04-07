<?php

namespace App\Repositories;

use App\Models\CricketGameStats;

class CricketGameStatsRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketGameStats
    {
        return CricketGameStats::updateOrCreate($attributes, $values);
    }
}
