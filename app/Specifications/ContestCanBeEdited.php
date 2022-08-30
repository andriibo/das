<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;

class ContestCanBeEdited
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        if ($contest->status !== StatusEnum::ready->value) {
            return false;
        }
        if ($contest->contestUsers->count() > 0) {
            return false;
        }

        return true;
    }
}
