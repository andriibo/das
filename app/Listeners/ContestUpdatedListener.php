<?php

namespace App\Listeners;

use App\Events\ContestUpdatedEvent;
use App\Jobs\PushContestUpdatedJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ContestUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(ContestUpdatedEvent $event): void
    {
        PushContestUpdatedJob::dispatch($event->contest);
    }
}
