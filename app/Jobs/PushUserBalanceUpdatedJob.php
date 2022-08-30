<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\BalanceResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class PushUserBalanceUpdatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly Authenticatable $user)
    {
    }

    public function handle(): void
    {
        try {
            $resource = new BalanceResource($this->user);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendUserBalanceUpdatePush($resource->jsonSerialize(), $this->user->id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
