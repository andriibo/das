<?php

namespace App\Events;

use App\Models\Contests\Contest;
use Illuminate\Foundation\Events\Dispatchable;

class GameLogsUpdatedEvent
{
    use Dispatchable;

    public function __construct(public readonly Contest $contest)
    {
    }
}
