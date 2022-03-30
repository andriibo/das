<?php

namespace App\Repositories;

use App\Models\CricketUnit;

class CricketUnitRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketUnit
    {
        return CricketUnit::updateOrCreate($attributes, $values);
    }
}
