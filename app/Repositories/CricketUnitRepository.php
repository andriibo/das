<?php

namespace App\Repositories;

use App\Models\CricketUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CricketUnitRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getByParams(int $playerFeedId, int $teamId): CricketUnit
    {
        return CricketUnit::query()
            ->whereHas('player', function (Builder $query) use ($playerFeedId) {
                $query->where('feed_id', $playerFeedId);
            })
            ->whereTeamId($teamId)
            ->firstOrFail()
        ;
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketUnit
    {
        return CricketUnit::updateOrCreate($attributes, $values);
    }
}
