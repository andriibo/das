<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LeagueSportIdEnum: int
{
    use Values;

    case soccer = 1;

    case football = 2;

    case cricket = 3;
}
