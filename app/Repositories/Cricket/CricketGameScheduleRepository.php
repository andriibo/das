<?php

namespace App\Repositories\Cricket;

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
}
