<?php

namespace App\Repositories;

use App\Models\CricketUnitStats;
use Illuminate\Database\Eloquent\Collection;

class CricketUnitStatsRepository
{
    /**
     * @return Collection|CricketUnitStats[]
     */
    public function getList(): Collection
    {
        return CricketUnitStats::query()
            ->whereNotNull('game_schedule_id')
            ->get()
        ;
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketUnitStats
    {
        return CricketUnitStats::updateOrCreate($attributes, $values);
    }

    public function getRealGameUnitStatsByUnitId(int $unitId): Collection
    {
        return CricketUnitStats::query()
            ->where(['unit_id' => $unitId])
            ->havingNotNull('game_schedule_id')
            ->join('cricket_game_schedule', function ($join) {
                $join->on('cricket_unit_stats.game_schedule_id', '=', 'cricket_game_schedule.id')
                    ->where('is_fake', '=', '0')
                ;
            })->get();
    }
}
