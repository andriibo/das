<?php

namespace App\Console\Commands;

use App\Mappers\CricketPlayerMapper;
use App\Services\CricketGoalserveService;
use App\Services\CricketPlayerService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketPlayerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:player';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get players for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     */
    public function handle(CricketPlayerService $cricketPlayerService)
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketPlayers = $cricketPlayerService->getCricketPlayers();
        foreach ($cricketPlayers as $cricketPlayer) {
            $this->parseCricketPlayer($cricketPlayer->feed_id);
        }
    }

    private function parseCricketPlayer(int $feedId): void
    {
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $cricketPlayerService = resolve(CricketPlayerService::class);
        $cricketPlayerMapper = new CricketPlayerMapper();

        try {
            $data = $cricketGoalserveService->getGoalserveCricketPlayer($feedId);
            if (empty($data)) {
                $this->error("No data for player with feed_id {$feedId}");

                return;
            }

            $cricketPlayerDto = $cricketPlayerMapper->map($data);
            $cricketPlayerService->storeCricketPlayer($cricketPlayerDto);
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }
}
