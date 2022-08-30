<?php

namespace App\Listeners;

use App\Events\UserBalanceUpdatedEvent;
use App\Jobs\PushUserBalanceUpdatedJob;
use Illuminate\Queue\InteractsWithQueue;

class UserBalanceUpdatedListener
{
    use InteractsWithQueue;

    public function handle(UserBalanceUpdatedEvent $event): void
    {
        PushUserBalanceUpdatedJob::dispatch($event->user);
    }
}
