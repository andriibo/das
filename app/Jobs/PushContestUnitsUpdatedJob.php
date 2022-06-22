<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\ContestUnitResource;
use App\Models\Contests\Contest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class PushContestUnitsUpdatedJob implements ShouldQueue
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
            $collection = ContestUnitResource::collection($this->contest->contestUnits);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendContestUnitsUpdatePush($collection->jsonSerialize(), $this->contest->id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
