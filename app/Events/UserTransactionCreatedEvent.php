<?php

namespace App\Events;

use App\Models\UserTransaction;
use Illuminate\Foundation\Events\Dispatchable;

class UserTransactionCreatedEvent
{
    use Dispatchable;

    public function __construct(public readonly UserTransaction $userTransaction)
    {
    }
}
