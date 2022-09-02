<?php

namespace App\Repositories;

use App\Models\Contests\ContestUser;
use Illuminate\Database\Eloquent\Collection;

class ContestUserRepository
{
    /* @return Collection|ContestUser[] */
    public function getContestWinners(int $contestId, int $maxPlace): Collection
    {
        return ContestUser::query()
            ->where('contest_id', $contestId)
            ->where('place', '<=', $maxPlace)
            ->where('place', '>', 0)
            ->orderBy('place')
            ->get()
        ;
    }

    public function update(ContestUser $contestUser, array $params): bool
    {
        return $contestUser->update($params);
    }
}
