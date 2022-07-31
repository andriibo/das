<?php

namespace App\Listeners;

use App\Clients\NodejsClient;
use App\Events\GameLogsUpdatedEvent;
use App\Jobs\PushGameLogsUpdatedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GameLogsUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(private readonly NodejsClient $nodejsClient)
    {
    }

    public function handle(GameLogsUpdatedEvent $event): void
    {
        PushGameLogsUpdatedJob::dispatch($event->contest);
    }
}
