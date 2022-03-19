<?php

namespace App\Repositories;

use App\Enums\LeagueIsEnabledEnum;
use App\Enums\LeagueSportIdEnum;
use App\Models\League;
use Illuminate\Support\Collection;

class LeagueRepository
{
    /**
     * @return Collection|League[]
     */
    public function getListBySportId(LeagueSportIdEnum $sportIdEnum): Collection
    {
        return League::query()
            ->where('sport_id', $sportIdEnum)
            ->where('is_enabled', LeagueIsEnabledEnum::isEnabled)
            ->get()
        ;
    }
}
