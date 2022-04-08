<?php

namespace App\Events;

use App\Models\CricketPlayer;
use Illuminate\Foundation\Events\Dispatchable;

class CricketPlayerSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketPlayer $cricketPlayer)
    {
    }
}
