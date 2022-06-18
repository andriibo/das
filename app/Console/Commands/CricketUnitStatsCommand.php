<?php

namespace App\Console\Commands;

use App\Mappers\CricketUnitStatsMapper;
use App\Models\CricketGameStats;
use App\Repositories\CricketGameStatsRepository;
use App\Repositories\CricketTeamRepository;
use App\Services\CricketUnitStatsService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CricketUnitStatsCommand extends Command
{
    protected $signature = 'cricket:unit-stats';

    protected $description = 'Get unit stats from game stats';

    public function handle(CricketGameStatsRepository $cricketGameStatsRepository): void
    {
        $this->info(Carbon::now() . ": Command {$this->signature} started");
        $gameStats = $cricketGameStatsRepository->getList();
        foreach ($gameStats as $gameStat) {
            $this->parseGameStat($gameStat);
        }
        $this->info(Carbon::now() . ": Command {$this->signature} finished");
    }

    private function parseGameStat(CricketGameStats $cricketGameStats): void
    {
        $cricketTeamRepository = new CricketTeamRepository();

        try {
            $match = $cricketGameStats->raw_stats['match'];
            $homeTeamId = $cricketTeamRepository->getByFeedId($match['localteam']['id'])->id;
            $awayTeamId = $cricketTeamRepository->getByFeedId($match['visitorteam']['id'])->id;

            if (!isset($match['inning'])) {
                return;
            }

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
        /* @var $cricketUnitStatsService CricketUnitStatsService
        * @var $cricketUnitStatsMapper CricketUnitStatsMapper */
        $cricketUnitStatsService = resolve(CricketUnitStatsService::class);
        $cricketUnitStatsMapper = resolve(CricketUnitStatsMapper::class);
        foreach ($players as $player) {
            $cricketUnitStatsDto = $cricketUnitStatsMapper->map([
                'game_id' => $gameScheduleId,
                'player_id' => $player['profileid'],
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
