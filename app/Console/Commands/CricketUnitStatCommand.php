<?php

namespace App\Console\Commands;

use App\Mappers\CricketUnitStatMapper;
use App\Models\CricketGameStat;
use App\Services\CricketGameStatService;
use App\Services\CricketTeamService;
use App\Services\CricketUnitStatService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketUnitStatCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:unit-stat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get unit stats from game stat';

    /**
     * Execute the console command.
     */
    public function handle(CricketGameStatService $cricketGameStatService): void
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $gameStats = $cricketGameStatService->getCricketGameStats();
        foreach ($gameStats as $gameStat) {
            $this->parseGameStat($gameStat);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseGameStat(CricketGameStat $cricketGameStat): void
    {
        /* @var $cricketTeamService CricketTeamService */
        $cricketTeamService = resolve(CricketTeamService::class);

        try {
            $match = $cricketGameStat->raw_stat['match'];
            $homeTeamId = $cricketTeamService->getCricketTeamByFeedId($match['localteam']['id'])->id;
            $awayTeamId = $cricketTeamService->getCricketTeamByFeedId($match['visitorteam']['id'])->id;

            $innings = $match['inning'];
            if (array_key_exists('batsmanstats', $innings) && array_key_exists('bowlers', $innings)) {
                $teamId = $this->getTeamId($innings['team'], $homeTeamId, $awayTeamId);
                $this->parseInning($innings, $cricketGameStat->cricket_game_schedule_id, $teamId);

                return;
            }

            foreach ($innings as $inning) {
                $teamId = $this->getTeamId($inning['team'], $homeTeamId, $awayTeamId);
                $this->parseInning($inning, $cricketGameStat->cricket_game_schedule_id, $teamId);
            }
        } catch (\Throwable $exception) {
            $this->error($exception->getMessage());
        }
    }

    private function parseInning(array $inning, int $gameScheduleId, int $teamId): void
    {
        $players = array_merge($inning['batsmanstats']['player'], $inning['bowlers']['player']);
        $this->parseUnitStats($players, $teamId, $gameScheduleId);
    }

    private function parseUnitStats(array $players, int $teamId, int $gameScheduleId): void
    {
        /* @var $cricketUnitStatService CricketUnitStatService */
        /* @var $cricketUnitStatMapper CricketUnitStatMapper */
        $cricketUnitStatService = resolve(CricketUnitStatService::class);
        $cricketUnitStatMapper = resolve(CricketUnitStatMapper::class);
        foreach ($players as $player) {
            $cricketUnitStatDto = $cricketUnitStatMapper->map([
                'game_id' => $gameScheduleId,
                'profile_id' => $player['profileid'],
                'team_id' => $teamId,
                'stat' => $player,
            ]);
            $cricketUnitStatService->storeCricketUnitStat($cricketUnitStatDto);
        }
    }

    private function getTeamId(string $team, int $homeTeamId, int $awayTeamId): int
    {
        return $team === 'localteam' ? $homeTeamId : $awayTeamId;
    }
}
