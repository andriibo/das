<?php

namespace App\Console\Commands;

use App\Mappers\CricketUnitStatsMapper;
use App\Models\CricketGameStats;
use App\Services\CricketGameStatsService;
use App\Services\CricketTeamService;
use App\Services\CricketUnitStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketUnitStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cricket:unit-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get unit stats from game stats';

    /**
     * Execute the console command.
     */
    public function handle(CricketGameStatsService $cricketGameStatsService): void
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $gameStats = $cricketGameStatsService->getCricketGameStats();
        foreach ($gameStats as $gameStat) {
            $this->parseGameStat($gameStat);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseGameStat(CricketGameStats $cricketGameStats): void
    {
        /* @var $cricketTeamService CricketTeamService */
        $cricketTeamService = resolve(CricketTeamService::class);

        try {
            $match = $cricketGameStats->raw_stats['match'];
            $homeTeamId = $cricketTeamService->getCricketTeamByFeedId($match['localteam']['id'])->id;
            $awayTeamId = $cricketTeamService->getCricketTeamByFeedId($match['visitorteam']['id'])->id;

            $innings = $match['inning'];
            if (array_key_exists('batsmanstats', $innings) && array_key_exists('bowlers', $innings)) {
                $teamId = $this->getTeamId($innings['team'], $homeTeamId, $awayTeamId);
                $this->parseInning($innings, $cricketGameStats->game_schedule_id, $teamId);

                return;
            }

            foreach ($innings as $inning) {
                $teamId = $this->getTeamId($inning['team'], $homeTeamId, $awayTeamId);
                $this->parseInning($inning, $cricketGameStats->game_schedule_id, $teamId);
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
        /* @var $cricketUnitStatsService CricketUnitStatsService */
        /* @var $cricketUnitStatsMapper CricketUnitStatsMapper */
        $cricketUnitStatsService = resolve(CricketUnitStatsService::class);
        $cricketUnitStatsMapper = resolve(CricketUnitStatsMapper::class);
        foreach ($players as $player) {
            $cricketUnitStatsDto = $cricketUnitStatsMapper->map([
                'game_id' => $gameScheduleId,
                'profile_id' => $player['profileid'],
                'team_id' => $teamId,
                'stats' => $player,
            ]);
            $cricketUnitStatsService->storeCricketUnitStats($cricketUnitStatsDto);
        }
    }

    private function getTeamId(string $team, int $homeTeamId, int $awayTeamId): int
    {
        return $team === 'localteam' ? $homeTeamId : $awayTeamId;
    }
}
