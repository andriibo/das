<?php

namespace App\Events\Cricket;

use App\Models\Cricket\CricketTeam;
use Illuminate\Foundation\Events\Dispatchable;

class CricketTeamSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketTeam $cricketTeam)
    {
    }
}
