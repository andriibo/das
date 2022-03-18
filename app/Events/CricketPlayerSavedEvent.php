<?php

namespace App\Events;

use App\Models\CricketPlayer;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CricketPlayerSavedEvent
{
    use Dispatchable;
    use SerializesModels;

    public CricketPlayer $cricketPlayer;

    public function __construct(CricketPlayer $cricketPlayer)
    {
        $this->cricketPlayer = $cricketPlayer;
    }
}
