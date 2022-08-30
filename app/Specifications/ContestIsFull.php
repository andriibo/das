<?php

namespace App\Specifications;

use App\Models\Contests\Contest;

class ContestIsFull
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        return $contest->max_users > 0 && $contest->contestUsers->count() == $contest->max_users;
    }
}
