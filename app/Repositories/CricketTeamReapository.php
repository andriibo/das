<?php

namespace App\Repositories;

use App\Models\CricketTeam;

class CricketTeamReapository
{
    public function updateOrCreate(array $attributes, array $values = []): CricketTeam
    {
        return CricketTeam::updateOrCreate($attributes, $values);
    }
}
