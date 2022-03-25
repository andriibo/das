<?php

namespace App\Enums;

enum CricketGameScheduleStatusEnum: string
{
    case notStarted = 'Not Started';

    case inProgress = 'In Progress';

    case stumps = 'Stumps';

    case finished = 'Finished';
}
