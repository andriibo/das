<?php

namespace App\Enums\CricketGameSchedule;

use ArchTech\Enums\Values;

enum StatusEnum: string
{
    use Values;

    case notStarted = 'Not Started';

    case inProgress = 'In Progress';

    case stumps = 'Stumps';

    case finished = 'Finished';
}
