<?php

namespace App\Listeners;

use App\Events\NotifyInSlackEvent;
use App\Jobs\NotifyInSlackJob;
use Illuminate\Support\Facades\Log;

class NotifyInSlackListener
{
    public function handle(NotifyInSlackEvent $sendExceptionEvent): void
    {
        $message = $sendExceptionEvent->exception->getMessage();
        $location = $sendExceptionEvent->exception->getFile() . ':' . $sendExceptionEvent->exception->getLine();

        NotifyInSlackJob::dispatch($message, $location);

        Log::channel('stderr')->error($message);
    }
}
