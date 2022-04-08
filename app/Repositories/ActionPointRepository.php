<?php

namespace App\Repositories;

use App\Enums\IsEnabledEnum;
use App\Enums\SportIdEnum;
use App\Models\ActionPoint;
use Illuminate\Database\Eloquent\Collection;

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
}
