<?php

namespace App\Events;

use App\Models\CricketTeam;
use Illuminate\Foundation\Events\Dispatchable;

class CricketTeamSavedEvent
{
    use Dispatchable;

    public CricketTeam $cricketTeam;

    public function __construct(CricketTeam $cricketTeam)
    {
        $this->cricketTeam = $cricketTeam;
    }
}
