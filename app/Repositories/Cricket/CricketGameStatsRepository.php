<?php

namespace App\Repositories\Cricket;

use App\Models\Cricket\CricketGameStats;
use Illuminate\Support\Collection;

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
