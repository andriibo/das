<?php

namespace App\Repositories\Cricket;

use App\Enums\CricketUnit\IsActiveEnum;
use App\Models\Cricket\CricketUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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
        return CricketUnit::query()->updateOrCreate($attributes, $values);
    }

    public function setNotActiveByTeamId(int $teamId): void
    {
        CricketUnit::whereTeamId($teamId)->update(['is_active' => IsActiveEnum::no->value]);
    }

    /**
     * @param int[] $cricketUnitIds
     */
    public function setActiveByIds(array $cricketUnitIds): void
    {
        CricketUnit::query()->whereIn('id', $cricketUnitIds)
            ->update(['is_active' => IsActiveEnum::yes->value])
        ;
    }
}
