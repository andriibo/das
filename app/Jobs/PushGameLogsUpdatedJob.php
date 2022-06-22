<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\GameLogResource;
use App\Models\Contests\Contest;
use App\Repositories\Cricket\CricketGameLogRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class PushGameLogsUpdatedJob implements ShouldQueue
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
            $cricketGameLogRepository = new CricketGameLogRepository();
            $cricketGameLogs = $cricketGameLogRepository->getGameLogsByContestId($this->contest->id);

            $collection = GameLogResource::collection($cricketGameLogs);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendGameLogsUpdatePush($collection->jsonSerialize(), $this->contest->id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
