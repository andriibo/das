<?php

namespace App\Jobs;

use App\Mappers\Pusher\UserTransactionMapper;
use App\Models\UserTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Pusher\Services\SendUserTransactionCreatedPushService;

class PushUserTransactionCreatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly UserTransaction $userTransaction)
    {
    }

    public function handle(): void
    {
        /* @var UserTransactionMapper $userTransactionMapper */
        $userTransactionMapper = resolve(UserTransactionMapper::class);
        /* @var SendUserTransactionCreatedPushService $sendUserTransactionCreatedPushService */
        $sendUserTransactionCreatedPushService = resolve(SendUserTransactionCreatedPushService::class);

        $userTransactionDto = $userTransactionMapper->map($this->userTransaction);

        $sendUserTransactionCreatedPushService->handle($userTransactionDto, $this->userTransaction->user_id);
    }
}
