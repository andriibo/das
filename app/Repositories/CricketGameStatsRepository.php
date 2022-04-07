<?php

namespace App\Repositories;

use App\Models\CricketGameStats;
use Illuminate\Database\Eloquent\Collection;

class CricketGameStatsRepository
{
    /**
     * @return Collection|CricketGameStats[]
     */
    public function getList(): Collection
    {
        return CricketGameStats::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketGameStats
    {
        return CricketGameStats::updateOrCreate($attributes, $values);
    }
}
