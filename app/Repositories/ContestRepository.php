<?php

namespace App\Repositories;

use App\Enums\Contests\StatusEnum;
use App\Enums\Contests\SuspendedEnum;
use App\Models\Contests\Contest;
use Illuminate\Support\Collection;

class ContestRepository
{
    /**
     * @return Collection|Contest[]
     */
    public function getRunningContests(int $leagueId): Collection
    {
        return Contest::query()
            ->where('league_id', $leagueId)
            ->whereIn('status', [StatusEnum::started, StatusEnum::finished])
            ->where('suspended', SuspendedEnum::no)
            ->get()
        ;
    }
}
