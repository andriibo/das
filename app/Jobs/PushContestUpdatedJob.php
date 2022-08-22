<?php

namespace App\Jobs;

use App\Mappers\Nodejs\ContestMapper;
use App\Models\Contests\Contest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use NodeJsClient\Services\SendContestUpdatePushService;

class PushContestUpdatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly Contest $contest)
    {
    }

    public function handle(): void
    {
        /* @var ContestMapper $contestMapper */
        $contestMapper = resolve(ContestMapper::class);
        /* @var SendContestUpdatePushService $sendContestUpdatePushService */
        $sendContestUpdatePushService = resolve(SendContestUpdatePushService::class);

        $contestDto = $contestMapper->map($this->contest);

        $sendContestUpdatePushService->handle($contestDto);
    }
}
