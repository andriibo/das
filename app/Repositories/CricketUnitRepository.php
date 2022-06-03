<?php

namespace App\Repositories;

use App\Models\CricketUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @return Collection|CricketUnit[]
     */
    public function getList(): Collection
    {
        return CricketUnit::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketUnit
    {
        return CricketUnit::updateOrCreate($attributes, $values);
    }
}
