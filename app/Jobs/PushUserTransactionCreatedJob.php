<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\Transactions\TransactionResource;
use App\Models\UserTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

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
        try {
            $resource = new TransactionResource($this->userTransaction);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendUserTransactionCreatedPush($resource->jsonSerialize(), $this->userTransaction->user_id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
