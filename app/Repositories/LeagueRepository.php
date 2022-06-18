<?php

namespace App\Repositories;

use App\Enums\IsEnabledEnum;
use App\Enums\LeagueRecentlyEnabledEnum;
use App\Enums\SportIdEnum;
use App\Models\League;
use Illuminate\Database\Eloquent\Collection;

class LeagueRepository
{
    /**
     * @return Collection|League[]
     */
    public function getListBySportId(SportIdEnum $sportIdEnum): Collection
    {
        return League::query()
            ->where('sport_id', $sportIdEnum)
            ->where('is_enabled', IsEnabledEnum::isEnabled)
            ->get()
        ;
    }

    /**
     * @return Collection|League[]
     */
    public function getRecentlyEnabledListBySportId(SportIdEnum $sportIdEnum): Collection
    {
        return League::query()
            ->where('sport_id', $sportIdEnum)
            ->where('is_enabled', IsEnabledEnum::isEnabled)
            ->where('recently_enabled', LeagueRecentlyEnabledEnum::yes)
            ->get()
            ;
    }
}
