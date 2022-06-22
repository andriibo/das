<?php

namespace App\Events\Cricket;

use App\Models\Cricket\CricketUnitStats;
use Illuminate\Foundation\Events\Dispatchable;

class CricketUnitStatsSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketUnitStats $cricketUnitStats)
    {
    }
}
