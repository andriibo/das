<?php

namespace App\Events\Cricket;

use Illuminate\Foundation\Events\Dispatchable;

class CricketCommandSendExceptionEvent
{
    use Dispatchable;

    public function __construct(public \Exception $exception)
    {
    }
}
