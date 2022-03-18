<?php

namespace App\Events;

use App\Models\CricketTeam;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CricketTeamSavedEvent
{
    use Dispatchable;
    use SerializesModels;

    public CricketTeam $cricketTeam;

    public function __construct(CricketTeam $cricketTeam)
    {
        $this->cricketTeam = $cricketTeam;
    }
}
