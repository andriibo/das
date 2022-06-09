<?php

namespace App\Console\Commands;

use App\Enums\SportIdEnum;
use App\Mappers\CricketPlayerMapper;
use App\Mappers\CricketTeamMapper;
use App\Mappers\CricketUnitMapper;
use App\Models\CricketPlayer;
use App\Models\League;
use App\Repositories\LeagueRepository;
use App\Services\CricketGoalserveService;
use App\Services\CricketPlayerService;
use App\Services\CricketTeamService;
use App\Services\CricketUnitService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketTeamPlayerUnitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:team-player-unit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get teams for sport Cricket from Goalserve';

    /**
     * Execute the console command.
     */
    public function handle(LeagueRepository $leagueRepository)
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $leagues = $leagueRepository->getListBySportId(SportIdEnum::cricket);
        foreach ($leagues as $league) {
            $this->parseCricketTeams($league);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    public function parseCricketTeam(array $data, int $leagueId): void
    {
        /* @var $cricketTeamService CricketTeamService */
        $cricketTeamService = resolve(CricketTeamService::class);
        $cricketTeamMapper = new CricketTeamMapper();
        $cricketTeamDto = $cricketTeamMapper->map($data, $leagueId);
        $cricketTeam = $cricketTeamService->storeCricketTeam($cricketTeamDto);

        if (!$cricketTeam) {
            return;
        }
        foreach ($data['player'] as $player) {
            $cricketPlayer = $this->parseCricketPlayer($player);
            if (!$cricketPlayer) {
                continue;
            }

            $this->parseCricketUnit($cricketPlayer, $cricketTeam->id, $player['role']);
        }
    }

    public function parseCricketPlayer(array $data): CricketPlayer
    {
        /* @var $cricketPlayerService CricketPlayerService */
        $cricketPlayerService = resolve(CricketPlayerService::class);
        $cricketPlayerMapper = new CricketPlayerMapper();
        $cricketPlayerDto = $cricketPlayerMapper->map([
            'id' => $data['name'],
            'name' => $data['id'],
        ]);

        return $cricketPlayerService->storeCricketPlayer($cricketPlayerDto);
    }

    private function parseCricketTeams(League $league): void
    {
        /* @var $cricketGoalserveService CricketGoalserveService */
        $cricketGoalserveService = resolve(CricketGoalserveService::class);

        try {
            $leagueId = $league->params['league_id'];
            $teams = $cricketGoalserveService->getGoalserveCricketTeams($leagueId);
            foreach ($teams as $team) {
                $this->parseCricketTeam($team, $league->id);
            }
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function parseCricketUnit(CricketPlayer $cricketPlayer, int $teamId, string $position): void
    {
        $cricketUnitMapper = new CricketUnitMapper();
        /* @var $cricketUnitService CricketUnitService */
        $cricketUnitService = resolve(CricketUnitService::class);

        $cricketUnitDto = $cricketUnitMapper->map([
            'player_id' => $cricketPlayer->id,
            'team_id' => $teamId,
            'position' => $position,
        ]);

        $cricketUnitService->storeCricketUnit($cricketUnitDto);
    }
}
