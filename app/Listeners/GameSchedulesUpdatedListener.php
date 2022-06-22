<?php

namespace App\Listeners;

use App\Clients\NodejsClient;
use App\Events\GameSchedulesUpdatedEvent;
use App\Jobs\PushGameSchedulesUpdatedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GameSchedulesUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct(private readonly NodejsClient $nodejsClient)
    {
    }

    public function handle(GameSchedulesUpdatedEvent $event): void
    {
        PushGameSchedulesUpdatedJob::dispatch($event->contest);
    }
}
