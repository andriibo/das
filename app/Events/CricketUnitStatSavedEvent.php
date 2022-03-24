<?php

namespace App\Events;

use App\Models\CricketUnitStat;
use Illuminate\Foundation\Events\Dispatchable;

class CricketUnitStatSavedEvent
{
    use Dispatchable;

    public CricketUnitStat $cricketUnitStat;

    public function __construct(CricketUnitStat $cricketUnitStat)
    {
        $this->cricketUnitStat = $cricketUnitStat;
    }
}
