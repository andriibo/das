<?php

namespace App\Repositories;

use App\Models\CricketGameSchedule;
use Illuminate\Database\Eloquent\Collection;

class CricketGameScheduleRepository
{
    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getList(): Collection
    {
        return CricketGameSchedule::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketGameSchedule
    {
        return CricketGameSchedule::updateOrCreate($attributes, $values);
    }
}
