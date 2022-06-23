<?php

namespace App\Repositories\Cricket;

use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsFakeEnum;
use App\Models\Cricket\CricketGameSchedule;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class CricketGameScheduleRepository
{
    /**
     * @throws ModelNotFoundException
     */
    public function getByFeedId(string $feedId): CricketGameSchedule
    {
        return CricketGameSchedule::whereFeedId($feedId)->firstOrFail();
    }

    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getList(): Collection
    {
        return CricketGameSchedule::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketGameSchedule
    {
        return CricketGameSchedule::updateOrCreate($attributes, $values);
    }

    /**
     * @return Collection|CricketGameSchedule[]
     */
    public function getHistorical(int $leagueId): Collection
    {
        return CricketGameSchedule::query()
            ->where('league_id', $leagueId)
            ->where('game_date', '<', date('Y-m-d H:i:s'))
            ->where('has_final_box', HasFinalBoxEnum::yes)
            ->where('is_fake', IsFakeEnum::no)
            ->orderByDesc('game_date')
            ->get()
        ;
    }
}
