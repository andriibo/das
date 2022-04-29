<?php

namespace App\Events;

use App\Models\CricketUnit;
use Illuminate\Foundation\Events\Dispatchable;

class CricketUnitSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketUnit $cricketUnit)
    {
    }
}
