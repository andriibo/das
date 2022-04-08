<?php

namespace App\Events;

use App\Models\CricketGameStats;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameStatsSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketGameStats $cricketGameStats)
    {
    }
}
