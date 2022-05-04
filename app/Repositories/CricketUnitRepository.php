<?php

namespace App\Repositories;

use App\Models\CricketUnit;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CricketUnitRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getByParams(int $teamId, int $playerId): CricketUnit
    {
        return CricketUnit::query()
            ->whereTeamId($teamId)
            ->wherePlayerId($playerId)
            ->firstOrFail()
        ;
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketUnit
    {
        return CricketUnit::updateOrCreate($attributes, $values);
    }
}
