<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum GameStatusEnum: string
{
    use Values;

    case finalGame = 'FULL-TIME';

    case finalSchedule = 'FT';

    case postponed = 'POSTP';

    case canceled = 'CANCL';

    case abandoned = 'ABAN';

    case afterExtraTime = 'AET';

    case toBeAnnounced = 'TBA';

    case penalty = 'Pen.';
}
