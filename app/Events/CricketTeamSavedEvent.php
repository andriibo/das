<?php

namespace App\Events;

use App\Models\CricketTeam;
use Illuminate\Foundation\Events\Dispatchable;

class CricketTeamSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketTeam $cricketTeam)
    {
    }
}
