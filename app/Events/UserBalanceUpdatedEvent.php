<?php

namespace App\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;

class UserBalanceUpdatedEvent
{
    use Dispatchable;

    public function __construct(public readonly Authenticatable $user)
    {
    }
}
