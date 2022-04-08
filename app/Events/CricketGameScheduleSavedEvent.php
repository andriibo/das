<?php

namespace App\Events;

use App\Models\CricketGameSchedule;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameScheduleSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketGameSchedule $cricketGameSchedule)
    {
    }
}
