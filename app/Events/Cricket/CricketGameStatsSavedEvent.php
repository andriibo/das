<?php

namespace App\Events\Cricket;

use App\Models\Cricket\CricketGameStats;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameStatsSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketGameStats $cricketGameStats)
    {
    }
}
