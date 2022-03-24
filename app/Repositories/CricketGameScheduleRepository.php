<?php

namespace App\Repositories;

use App\Models\CricketGameSchedule;

class CricketGameScheduleRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketGameSchedule
    {
        return CricketGameSchedule::updateOrCreate($attributes, $values);
    }
}
