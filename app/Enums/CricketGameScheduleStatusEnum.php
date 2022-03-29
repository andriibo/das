<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum CricketGameScheduleStatusEnum: string
{
    use Values;

    case notStarted = 'Not Started';

    case inProgress = 'In Progress';

    case stumps = 'Stumps';

    case finished = 'Finished';
}
