<?php

namespace App\Events;

use App\Models\CricketGameSchedule;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameScheduleSavedEvent
{
    use Dispatchable;

    public CricketGameSchedule $cricketGameSchedule;

    public function __construct(CricketGameSchedule $cricketGameSchedule)
    {
        $this->cricketGameSchedule = $cricketGameSchedule;
    }
}
