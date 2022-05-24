<?php

namespace App\Enums\CricketUnit;

use ArchTech\Enums\Values;

enum CricketUnitStatActionEnum: string
{
    use Values;

    case runs = 'r';

    case ballsFaced = 'b';

    case scored4s = 's4';

    case scored6s = 's6';

    case strikeRate = 'sr';

    case overs = 'o';

    case maidenOvers = 'm';

    case wickets = 'w';

    case noBalls = 'nb';

    case wides = 'wd';

    case economyRate = 'er';
}
