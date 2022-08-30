<?php

namespace App\Repositories\Soccer;

use App\Models\Soccer\SoccerUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SoccerUnitRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getUnitById(int $id): SoccerUnit
    {
        return SoccerUnit::findOrFail($id);
    }
}
