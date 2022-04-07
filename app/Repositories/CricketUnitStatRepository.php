<?php

namespace App\Repositories;

use App\Models\CricketUnitStat;

class CricketUnitStatRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketUnitStat
    {
        return CricketUnitStat::updateOrCreate($attributes, $values);
    }
}
