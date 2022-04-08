<?php

namespace App\Repositories;

use App\Models\CricketUnitStats;
use Illuminate\Database\Eloquent\Collection;

class CricketUnitStatsRepository
{
    /**
     * @return Collection|CricketUnitStats[]
     */
    public function getList(): Collection
    {
        return CricketUnitStats::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketUnitStats
    {
        return CricketUnitStats::updateOrCreate($attributes, $values);
    }
}
