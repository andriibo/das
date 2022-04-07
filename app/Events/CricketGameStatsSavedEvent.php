<?php

namespace App\Events;

use App\Models\CricketGameStats;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameStatsSavedEvent
{
    use Dispatchable;

    public CricketGameStats $cricketGameStats;

    public function __construct(CricketGameStats $cricketGameStats)
    {
        $this->cricketGameStats = $cricketGameStats;
    }
}
