<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\ContestUserResource;
use App\Models\Contests\Contest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class PushContestUsersUpdatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly Contest $contest)
    {
    }

    public function handle(): void
    {
        try {
            $collection = ContestUserResource::collection($this->contest->contestUsers);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendContestUsersUpdatePush($collection->jsonSerialize(), $this->contest->id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
