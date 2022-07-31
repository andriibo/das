<?php

namespace App\Events\Cricket;

use App\Models\Cricket\CricketUnit;
use Illuminate\Foundation\Events\Dispatchable;

class CricketUnitSavedEvent
{
    use Dispatchable;

    public function __construct(public CricketUnit $cricketUnit)
    {
    }
}
