<?php

namespace App\Repositories\Cricket;

use App\Models\Cricket\CricketTeam;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class CricketTeamRepository
{
    /**
     * @return Collection|CricketTeam[]
     */
    public function getList(): Collection
    {
        return CricketTeam::all();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByFeedId(string $feedId): CricketTeam
    {
        return CricketTeam::whereFeedId($feedId)->firstOrFail();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketTeam
    {
        return CricketTeam::updateOrCreate($attributes, $values);
    }
}
