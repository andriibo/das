<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum LeagueIsEnabledEnum: int
{
    use Values;

    case isNotEnabled = 0;

    case isEnabled = 1;
}
