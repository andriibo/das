<?php

namespace App\Listeners;

use App\Events\GameLogsUpdatedEvent;
use App\Jobs\PushGameLogsUpdatedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GameLogsUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(GameLogsUpdatedEvent $event): void
    {
        PushGameLogsUpdatedJob::dispatch($event->contest);
    }
}
