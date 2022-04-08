<?php

namespace App\Events;

use App\Models\CricketUnitStats;
use Illuminate\Foundation\Events\Dispatchable;

class CricketUnitStatsSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketUnitStats $cricketUnitStats)
    {
    }
}
