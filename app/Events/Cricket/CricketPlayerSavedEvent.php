<?php

namespace App\Events\Cricket;

use App\Models\Cricket\CricketPlayer;
use Illuminate\Foundation\Events\Dispatchable;

class CricketPlayerSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketPlayer $cricketPlayer)
    {
    }
}
