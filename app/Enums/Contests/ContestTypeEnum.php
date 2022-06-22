<?php

namespace App\Enums\Contests;

use ArchTech\Enums\Values;

enum ContestTypeEnum: string
{
    use Values;

    case fiftyFifty = 'fifty-fifty';

    case headToHead = 'head-to-head';

    case multiplier = 'multiplier';

    case wta = 'wta';

    case topThree = 'top-three';

    case custom = 'custom';
}
