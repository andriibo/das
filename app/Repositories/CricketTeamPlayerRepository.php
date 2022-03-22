<?php

namespace App\Repositories;

use App\Models\CricketTeamPlayer;

class CricketTeamPlayerRepository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketTeamPlayer
    {
        return CricketTeamPlayer::updateOrCreate($attributes, $values);
    }
}
