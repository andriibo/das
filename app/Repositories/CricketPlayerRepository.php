<?php

namespace App\Repositories;

use App\Models\CricketPlayer;
use Illuminate\Database\Eloquent\Collection;

class CricketPlayerRepository
{
    /**
     * @return Collection|CricketPlayer[]
     */
    public function getList(): Collection
    {
        return CricketPlayer::all();
    }

    public function updateOrCreate(array $attributes, array $values = []): CricketPlayer
    {
        return CricketPlayer::updateOrCreate($attributes, $values);
    }
}
