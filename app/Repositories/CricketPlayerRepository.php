<?php

namespace App\Repositories;

use App\Models\CricketPlayer;

class CricketPlayerRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketPlayer
    {
        return CricketPlayer::updateOrCreate($attributes, $values);
    }
}
