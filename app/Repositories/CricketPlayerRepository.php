<?php

namespace App\Repositories;

use App\Models\CricketPlayer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CricketPlayerRepository
{
    /**
     * @return Collection|CricketPlayer[]
     */
    public function getList(): Collection
    {
        return CricketPlayer::all();
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByFeedId(string $feedId): CricketPlayer
    {
        return CricketPlayer::whereFeedId($feedId)->firstOrFail();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketPlayer
    {
        return CricketPlayer::updateOrCreate($attributes, $values);
    }
}
