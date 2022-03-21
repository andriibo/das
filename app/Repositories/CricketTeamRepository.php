<?php

namespace App\Repositories;

use App\Models\CricketTeam;
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

    public function updateOrCreate(array $attributes, array $values = []): CricketTeam
    {
        return CricketTeam::updateOrCreate($attributes, $values);
    }
}
