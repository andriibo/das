<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;

class ContestStatusAllowsStart
{
    public function __construct(private readonly ContestIsSuspended $contestIsSuspended)
    {
    }

    public function isSatisfiedBy(Contest $contest): bool
    {
        return $contest->status === StatusEnum::ready->value && !$this->contestIsSuspended->isSatisfiedBy($contest);
    }
}
