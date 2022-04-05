<?php

namespace App\Repositories;

use App\Models\CricketGameStat;

class CricketGameStatRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketGameStat
    {
        return CricketGameStat::updateOrCreate($attributes, $values);
    }
}
