<?php

namespace App\Listeners;

use App\Events\UserTransactionCreatedEvent;
use App\Jobs\PushUserTransactionCreatedJob;
use Illuminate\Queue\InteractsWithQueue;

class UserTransactionCreatedListener
{
    use InteractsWithQueue;

    public function handle(UserTransactionCreatedEvent $event): void
    {
        PushUserTransactionCreatedJob::dispatch($event->userTransaction);
    }
}
