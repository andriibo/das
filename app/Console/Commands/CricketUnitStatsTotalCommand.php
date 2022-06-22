<?php

namespace App\Console\Commands;

use App\Repositories\Cricket\CricketUnitRepository;
use App\Services\Cricket\CalculateCricketUnitStatsTotalService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketUnitStatsTotalCommand extends Command
{
    protected $signature = 'cricket:unit-stats-total';

    protected $description = 'Calculate total cricket unit stats';

    public function handle(
        CricketUnitRepository $cricketUnitRepository,
        CalculateCricketUnitStatsTotalService $calculateUnitStatsTotalService
    ): void {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketUnits = $cricketUnitRepository->getList();
        foreach ($cricketUnits as $cricketUnit) {
            $calculateUnitStatsTotalService->handle($cricketUnit);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
