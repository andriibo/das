<?php

namespace App\Events;

use App\Models\CricketUnitStats;
use Illuminate\Foundation\Events\Dispatchable;

class CricketUnitStatsSavedEvent
{
    use Dispatchable;

    public CricketUnitStats $cricketUnitStats;

    public function __construct(CricketUnitStats $cricketUnitStats)
    {
        $this->cricketUnitStats = $cricketUnitStats;
    }
}
