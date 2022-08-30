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

    /**
     * @return Collection|Contest[]
     */
    public function getActiveContests(): Collection
    {
        return Contest::query()
            ->whereIn('status', [
                StatusEnum::ready,
                StatusEnum::started,
                StatusEnum::finished,
            ])
            ->get()
            ;
    }

    public function updateStatus(Contest $contest, StatusEnum $status): bool
    {
        return $contest->update(['status' => $status->value]);
    }
}
