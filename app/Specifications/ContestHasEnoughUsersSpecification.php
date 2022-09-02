<?php

namespace App\Specifications;

use App\Models\Contests\Contest;

class ContestHasEnoughUsersSpecification
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        if ($contest->min_users > 0 && $contest->contestUsers->count() < $contest->min_users) {
            return false;
        }

        return true;
    }
}
