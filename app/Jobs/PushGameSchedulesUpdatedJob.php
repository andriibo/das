<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\GameScheduleResource;
use App\Models\Contests\Contest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class PushGameSchedulesUpdatedJob implements ShouldQueue
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
            $collection = GameScheduleResource::collection($this->contest->cricketGameSchedules);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendGameSchedulesUpdatePush($collection->jsonSerialize(), $this->contest->id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
