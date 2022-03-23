<?php

namespace App\Repositories;

use App\Models\CricketTeam;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @throws ModelNotFoundException<CricketTeam>
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
