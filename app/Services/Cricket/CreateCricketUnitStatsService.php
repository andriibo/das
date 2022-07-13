<?php

namespace App\Services\Cricket;

use App\Enums\SportIdEnum;
use App\Mappers\CricketUnitStatsMapper;
use App\Models\Cricket\CricketGameStats;
use App\Repositories\ActionPointRepository;
use App\Repositories\Cricket\CricketTeamRepository;
use Illuminate\Support\Facades\Log;

class CreateCricketUnitStatsService
{
    public function __construct(
        private readonly CreateCricketGameLogsService $createCricketGameLogsService,
        private readonly CricketUnitStatsService $cricketUnitStatsService,
        private readonly CricketUnitStatsMapper $cricketUnitStatsMapper
    ) {
    }

    public function handle(CricketGameStats $cricketGameStats)
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
            Log::channel('stderr')->error($exception->getMessage());
        }
    }

    private function parseUnitStats(array $players, int $teamId, int $gameScheduleId): void
    {
        $actionPointRepository = new ActionPointRepository();
        $actionPoints = $actionPointRepository->getListBySportId(SportIdEnum::cricket)->toArray();
        foreach ($players as $player) {
            if (!is_array($player)) {
                continue;
            }

            try {
                $stats = $this->getFormattedStats($player, $actionPoints);
                $cricketUnitStatsDto = $this->cricketUnitStatsMapper->map([
                    'game_id' => $gameScheduleId,
                    'player_id' => $player['profileid'],
                    'team_id' => $teamId,
                    'stats' => $stats,
                ]);
                $cricketUnitStats = $this->cricketUnitStatsService->storeCricketUnitStats($cricketUnitStatsDto);
                $this->createCricketGameLogsService->handle($cricketUnitStats, $actionPoints);
            } catch (\Throwable $exception) {
                Log::channel('stderr')->error($exception->getMessage());
            }
        }
    }

    private function getFormattedStats(array $stats, array $actionPoints): array
    {
        $formattedStats = [];
        foreach ($stats as $stat => $value) {
            $foundKey = array_search($stat, array_column($actionPoints, 'name'));
            if ($foundKey === false) {
                continue;
            }
            if ($value) {
                $formattedStats[$stat] = (float) $value;
            }
        }

        return $formattedStats;
    }

    private function parseInning(array $inning, int $gameScheduleId, int $teamId): void
    {
        $players = array_merge($inning['batsmanstats']['player'], $inning['bowlers']['player']);
        $this->parseUnitStats($players, $teamId, $gameScheduleId);
    }

    private function getTeamId(string $team, int $homeTeamId, int $awayTeamId): int
    {
        return $team === 'localteam' ? $awayTeamId : $homeTeamId;
    }
}
