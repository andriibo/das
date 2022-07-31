<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LeagueRecentlyEnabledEnum: int
{
    use Values;

    case no = 0;

    case yes = 1;
}
