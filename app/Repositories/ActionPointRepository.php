<?php

namespace App\Repositories;

use App\Enums\IsEnabledEnum;
use App\Enums\SportIdEnum;
use App\Models\ActionPoint;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

class ActionPointRepository
{
    /**
     * @return ActionPoint[]|Collection
     */
    public function getListBySportId(SportIdEnum $sportIdEnum): Collection
    {
        return ActionPoint::query()
            ->where('sport_id', $sportIdEnum)
            ->where('is_enabled', IsEnabledEnum::isEnabled)
            ->get()
        ;
    }

    /**
     * @return ActionPoint[]|Collection
     */
    public function getActionPoints(int $contestId): Collection
    {
        return ActionPoint::query()
            ->select('action_points.*', 'contest_action_points.values as values')
            ->join('contest_action_points', function (Builder $query) use ($contestId) {
                $query
                    ->on('contest_action_points.action_points_id', '=', 'action_points.id')
                    ->where('contest_id', $contestId)
                ;
            })
            ->where('is_enabled', IsEnabledEnum::isEnabled)
            ->get()
            ;
    }
}
