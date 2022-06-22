<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Values;

enum StatusEnum: int
{
    use Values;

    case ready = 1;

    case started = 2;

    case finished = 3;

    case closed = 4;

    case cancelled = 5;
}
