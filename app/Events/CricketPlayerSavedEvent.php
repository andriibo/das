<?php

namespace App\Events;

use App\Models\CricketPlayer;
use Illuminate\Foundation\Events\Dispatchable;

class CricketPlayerSavedEvent
{
    use Dispatchable;

    public CricketPlayer $cricketPlayer;

    public function __construct(CricketPlayer $cricketPlayer)
    {
        $this->cricketPlayer = $cricketPlayer;
    }
}
