<?php

namespace App\Console\Commands;

use App\Services\CricketGoalserveService;
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
    public function handle(
        CricketGoalserveService $cricketService,
        CricketTeamService $cricketTeamService
    ) {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $cricketTeams = $cricketTeamService->getCricketTeams();
        foreach ($cricketTeams as $cricketTeam) {
            foreach ($cricketTeam->cricketPlayers as $cricketPlayer) {
                try {
                    $data = $cricketService->getGoalserveCricketPlayer($cricketPlayer->feed_id);
                    if (!empty($data)) {
                        $cricketTeamPlayer = $cricketPlayer
                            ->cricketTeamPlayers()
                            ->where('cricket_team_id', $cricketTeam->id)
                            ->firstOrFail()
                        ;
                        if ($cricketTeamPlayer) {
                            $cricketTeamPlayer->playing_role = $data['playing_role'] ?? null;
                            $cricketTeamPlayer->save();
                            $this->info("Player: {$cricketPlayer->first_name}, Info added!");
                        }
                    } else {
                        $this->error("No data for player with feed_id {$cricketPlayer->feed_id}");
                    }
                } catch (\Throwable $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
