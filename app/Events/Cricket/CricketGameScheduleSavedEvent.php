<?php

namespace App\Events\Cricket;

use App\Models\Cricket\CricketGameSchedule;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameScheduleSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketGameSchedule $cricketGameSchedule)
    {
    }
}
