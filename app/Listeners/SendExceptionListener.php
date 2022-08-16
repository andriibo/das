<?php

namespace App\Listeners;

use App\Events\SendExceptionEvent;
use App\Jobs\SendExceptionToSlackJob;
use Illuminate\Support\Facades\Log;

class SendExceptionListener
{
    public function handle(SendExceptionEvent $sendExceptionEvent): void
    {
        $message = $sendExceptionEvent->exception->getMessage();
        $location = $sendExceptionEvent->exception->getFile() . ':' . $sendExceptionEvent->exception->getLine();

        SendExceptionToSlackJob::dispatch($message, $location);

        Log::channel('stderr')->error($message);
    }
}
