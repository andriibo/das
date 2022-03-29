<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LeagueRecentlyEnabledEnum: int
{
    use Values;

    case recentlyNotEnabled = 0;

    case recentlyEnabled = 1;
}
