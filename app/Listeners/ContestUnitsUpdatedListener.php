<?php

namespace App\Listeners;

use App\Events\ContestUnitsUpdatedEvent;
use App\Jobs\PushContestUnitsUpdatedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ContestUnitsUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ContestUnitsUpdatedEvent $event): void
    {
        PushContestUnitsUpdatedJob::dispatch($event->contest);
    }
}
