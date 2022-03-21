<?php

namespace App\Console\Commands;

use App\Enums\LeagueSportIdEnum;
use App\Mappers\CricketPlayerMapper;
use App\Mappers\CricketTeamMapper;
use App\Services\CricketGoalserveService;
use App\Services\CricketPlayerService;
use App\Services\CricketTeamService;
use App\Services\LeagueService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketTeamCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:team';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get teams for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     */
    public function handle(
        CricketGoalserveService $cricketService,
        CricketTeamService $cricketTeamService,
        CricketPlayerService $cricketPlayerService,
        LeagueService $leagueService,
        CricketTeamMapper $cricketTeamMapper,
        CricketPlayerMapper $cricketPlayerMapper
    ) {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueService->getListBySportId(LeagueSportIdEnum::cricket);
        foreach ($leagues as $league) {
            if (isset($league->params['league_id'])) {
                $leagueId = $league->params['league_id'];

                try {
                    $cricketLeague = $cricketService->getGoalserveCricketLeague($leagueId);
                    foreach ($cricketLeague['squads']['category']['team'] as $team) {
                        $cricketTeamDto = $cricketTeamMapper->map($team, $league->id);
                        $cricketTeam = $cricketTeamService->storeCricketTeam($cricketTeamDto);
                        if ($cricketTeam) {
                            $this->info("Team: {$cricketTeam->name}, Info added!");
                            foreach ($team['player'] as $player) {
                                $cricketPlayerDto = $cricketPlayerMapper->map([
                                    'id' => $player['name'],
                                    'name' => $player['id'],
                                ]);
                                $cricketPlayer = $cricketPlayerService->storeCricketPlayer($cricketPlayerDto);
                                if ($cricketPlayer) {
                                    $this->info("Player: {$cricketPlayer->first_name}, Info added!");
                                    $cricketTeam->cricketPlayers()->attach($cricketPlayer->id);
                                }
                            }
                        }
                    }
                } catch (\Throwable $exception) {
                    $this->error($exception->getMessage());
                }
            }
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }
}
