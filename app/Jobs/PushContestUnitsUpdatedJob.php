<?php

namespace App\Jobs;

use App\Mappers\Pusher\ContestUnitMapper;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestUnit;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Pusher\Services\SendContestUnitsUpdatePushService;

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
        /* @var ContestUnitMapper $contestUnitMapper */
        $contestUnitMapper = resolve(ContestUnitMapper::class);
        /* @var SendContestUnitsUpdatePushService $sendContestUnitsUpdatePushService */
        $sendContestUnitsUpdatePushService = resolve(SendContestUnitsUpdatePushService::class);

        $contestUnitsList = $this->contest->contestUnits->map(function (ContestUnit $contestUnit) use ($contestUnitMapper) {
            return $contestUnitMapper->map($contestUnit);
        });

        $sendContestUnitsUpdatePushService->handle($contestUnitsList->toArray(), $this->contest->id);
    }
}
