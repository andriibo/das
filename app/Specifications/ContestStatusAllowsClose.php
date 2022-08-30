<?php

namespace App\Specifications;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;

class ContestStatusAllowsClose
{
    public function __construct(private readonly ContestIsSuspended $contestIsSuspended)
    {
    }

    public function isSatisfiedBy(Contest $contest): bool
    {
        return $contest->status === StatusEnum::finished->value && !$this->contestIsSuspended->isSatisfiedBy($contest);
    }
}
