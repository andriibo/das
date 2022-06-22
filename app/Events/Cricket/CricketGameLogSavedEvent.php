<?php

namespace App\Events\Cricket;

use App\Models\Cricket\CricketGameLog;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameLogSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketGameLog $cricketGameLog)
    {
    }
}
