<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;

class ContestStatusAllowsFinish
{
    public function __construct(private readonly ContestIsSuspended $contestIsSuspended)
    {
    }

    public function isSatisfiedBy(Contest $contest): bool
    {
        return $contest->status === StatusEnum::started->value && !$this->contestIsSuspended->isSatisfiedBy($contest);
    }
}
