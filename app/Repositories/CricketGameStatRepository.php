<?php

namespace App\Repositories;

use App\Models\CricketGameStat;
use Illuminate\Database\Eloquent\Collection;

class CricketGameStatRepository
{
    /**
     * @return Collection|CricketGameStat[]
     */
    public function getList(): Collection
    {
        return CricketGameStat::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketGameStat
    {
        return CricketGameStat::updateOrCreate($attributes, $values);
    }
}
