<?php

namespace App\Listeners\Cricket;

use App\Events\Cricket\CricketCommandSendExceptionEvent;
use App\Services\SendSlackNotificationService;
use Illuminate\Support\Facades\Log;

class CricketCommandSendExceptionListener
{
    public function __construct(private readonly SendSlackNotificationService $sendSlackNotificationService)
    {
    }

    public function handle(CricketCommandSendExceptionEvent $cricketCommandSendExceptionEvent)
    {
        $location = $cricketCommandSendExceptionEvent->exception->getFile() . ':' . $cricketCommandSendExceptionEvent->exception->getLine();
        $this->sendSlackNotificationService->handle($cricketCommandSendExceptionEvent->exception->getMessage(), $location);

        Log::channel('stderr')->error($cricketCommandSendExceptionEvent->exception->getMessage());
    }
}
