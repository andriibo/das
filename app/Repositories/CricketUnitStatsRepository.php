<?php

namespace App\Repositories;

use App\Models\CricketUnitStats;

class CricketUnitStatsRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketUnitStats
    {
        return CricketUnitStats::updateOrCreate($attributes, $values);
    }
}
