<?php

namespace App\Events;

use App\Models\CricketGameLog;
use Illuminate\Foundation\Events\Dispatchable;

class CricketGameLogSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketGameLog $cricketGameLog)
    {
    }
}
