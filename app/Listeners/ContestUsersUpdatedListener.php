<?php

namespace App\Listeners;

use App\Clients\NodejsClient;
use App\Events\ContestUsersUpdatedEvent;
use App\Jobs\PushContestUsersUpdatedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ContestUsersUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(private readonly NodejsClient $nodejsClient)
    {
    }

    public function handle(ContestUsersUpdatedEvent $event): void
    {
        PushContestUsersUpdatedJob::dispatch($event->contest);
    }
}
