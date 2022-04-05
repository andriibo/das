<?php

namespace App\Repositories;

use App\Models\CricketGameSchedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
