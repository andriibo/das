<?php

namespace App\Jobs;

use App\Services\SendSlackNotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class SendExceptionToSlackJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly string $message, private readonly string $location)
    {
    }

    public function handle(): void
    {
        /* @var $sendSlackNotificationService SendSlackNotificationService */
        $sendSlackNotificationService = resolve(SendSlackNotificationService::class);

        $sendSlackNotificationService->handle($this->message, $this->location);
    }
}
