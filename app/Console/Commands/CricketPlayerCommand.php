<?php

namespace App\Console\Commands;

use App\Mappers\CricketPlayerMapper;
use App\Services\CricketGoalserveService;
use App\Services\CricketPlayerService;
use App\Services\CricketTeamService;
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
    public function handle(CricketTeamService $cricketTeamService)
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketTeams = $cricketTeamService->getCricketTeams();
        foreach ($cricketTeams as $cricketTeam) {
            foreach ($cricketTeam->cricketPlayers as $cricketPlayer) {
                $this->parseCricketPlayer($cricketPlayer->feed_id);
            }
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseCricketPlayer(int $feedId)
    {
        $cricketGoalserveService = resolve(CricketGoalserveService::class);
        $cricketPlayerService = resolve(CricketPlayerService::class);
        $cricketPlayerMapper = new CricketPlayerMapper();

        try {
            $data = $cricketGoalserveService->getGoalserveCricketPlayer($feedId);
            if (!empty($data)) {
                $cricketPlayerDto = $cricketPlayerMapper->map($data);
                $cricketPlayer = $cricketPlayerService->storeCricketPlayer($cricketPlayerDto);
                if ($cricketPlayer) {
                    $this->info("Player: {$cricketPlayer->first_name}, Info added!");
                }
            } else {
                $this->error("No data for player with feed_id {$feedId}");
            }
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }
}
