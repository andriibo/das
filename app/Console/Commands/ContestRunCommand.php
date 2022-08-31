<?php

namespace App\Console\Commands;

use App\Events\NotifyInSlackEvent;
use App\Repositories\ContestRepository;
use App\Services\Contest\ContestRunService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ContestRunCommand extends Command
{
    protected $signature = 'contest:run';

    protected $description = 'Run contests';

    public function handle(
        ContestRepository $contestRepository,
        ContestRunService $contestRunService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");

        $activeContests = $contestRepository->getActiveContests();

        foreach ($activeContests as $activeContest) {
            try {
                $contestRunService->handle($activeContest);
            } catch (\Throwable $exception) {
                event(new NotifyInSlackEvent($exception));
            }
        }

        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
