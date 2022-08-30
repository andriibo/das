<?php

namespace App\Repositories\Soccer;

use App\Models\Soccer\SoccerUnitStats;
use Illuminate\Support\Collection;

class SoccerUnitStatsRepository
{
    /**
     * @return Collection|SoccerUnitStats[]
     */
    public function getByParams(int $unitId, array $gameScheduleIds): Collection
    {
        return SoccerUnitStats::query()
            ->where('unit_id', $unitId)
            ->whereIn('game_id', $gameScheduleIds)
            ->get()
            ;
    }
}
