<?php

namespace App\Services\Cricket;

use App\Helpers\CricketGameScheduleHelper;
use App\Models\League;
use App\Repositories\ContestRepository;
use App\Repositories\Cricket\CricketGameLogRepository;
use App\Services\CalculateContestService;

class CreateCricketStatsService
{
    public function __construct(
        private readonly CalculateContestService $calculateContestService,
        private readonly CreateCricketGameStatsService $createCricketGameStatsService,
        private readonly ConfirmCricketGameScheduleService $confirmCricketGameScheduleService
    ) {
    }

    public function handle(League $league)
    {
        $contestRepository = new ContestRepository();
        $cricketGameLogRepository = new CricketGameLogRepository();
        $runningContests = $contestRepository->getRunningContests($league->id);
        $gamesLoaded = $gamesConfirmed = [];
        foreach ($runningContests as $contest) {
            $lastGameLogId = $cricketGameLogRepository->getLastGameLogByContestId($contest->id)?->id ?? 0;
            $liveGames = $contest->liveCricketGameSchedules()->wherePivotNotIn('cricket_game_schedule.id', $gamesLoaded)->get();
            foreach ($liveGames as $liveGame) {
                $this->createCricketGameStatsService->handle($liveGame);
                $gamesLoaded[] = $liveGame->id;
            }
            $unconfirmedGames = $contest->unconfirmedCricketGameSchedules()->wherePivotNotIn('cricket_game_schedule.id', $gamesLoaded)->get();
            foreach ($unconfirmedGames as $unconfirmedGame) {
                if (CricketGameScheduleHelper::canConfirmData($unconfirmedGame)) {
                    $this->createCricketGameStatsService->handle($unconfirmedGame);
                    $this->confirmCricketGameScheduleService->handle($unconfirmedGame);
                    $gamesLoaded[] = $unconfirmedGame->id;
                    $gamesConfirmed[] = $unconfirmedGame->id;
                }
            }
            if (!$this->hasNewGameLogs($contest->id, $lastGameLogId, $cricketGameLogRepository) && empty($gamesConfirmed)) {
                continue;
            }
            $this->calculateContestService->handle($contest);
        }
    }

    private function hasNewGameLogs(int $contestId, int $lastGameLogId, CricketGameLogRepository $cricketGameLogRepository): bool
    {
        $gameLog = $cricketGameLogRepository->getLastGameLogByContestId($contestId);

        return $gameLog && $gameLog->id > $lastGameLogId;
    }
}
