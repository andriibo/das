<?php

namespace App\Events;

use App\Models\CricketGameStat;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameStatSavedEvent
{
    use Dispatchable;

    public CricketGameStat $cricketGameStat;

    public function __construct(CricketGameStat $cricketGameStat)
    {
        $this->cricketGameStat = $cricketGameStat;
    }
}
