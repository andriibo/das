<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class SendExceptionEvent
{
    use Dispatchable;

    public function __construct(public \Throwable $exception)
    {
    }
}
