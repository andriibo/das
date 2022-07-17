<?php

namespace App\Jobs;

use App\Clients\NodejsClient;
use App\Http\Resources\GameLogResource;
use App\Models\Contests\Contest;
use App\Services\GameLogService;
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
            /* @var $gameLogService GameLogService */
            $gameLogService = resolve(GameLogService::class);
            $gameLogs = $gameLogService->getGameLogs($this->contest);
            $collection = GameLogResource::customCollection($gameLogs, $this->contest->id);
            $nodejsClient = new NodejsClient();
            $nodejsClient->sendGameLogsUpdatePush($collection->jsonSerialize(), $this->contest->id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}
