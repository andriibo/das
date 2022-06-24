<?php

namespace App\Services\Cricket;

use App\Const\CricketGameScheduleConst;
use App\Models\League;
use App\Repositories\ContestRepository;
use App\Repositories\Cricket\CricketGameLogRepository;
use App\Services\CalculateContestService;

class CreateCricketStatsService
{
    public function __construct(
        private readonly CalculateContestService $calculateContestService,
        private readonly CreateCricketGameStatsService $createCricketGameStatsService,
        private readonly ConfirmCricketGameStatsService $confirmCricketGameStatsService
    ) {
    }

    public function handle(League $league)
    {
        $contestRepository = new ContestRepository();
        $cricketGameLogRepository = new CricketGameLogRepository();
        $runningContests = $contestRepository->getRunningContests($league->id);
        $gamesLoaded = $gamesConfirmed = [];
        foreach ($runningContests as $contest) {
            $lastGameLog = $cricketGameLogRepository->getLastGameLogByContestId($contest->id);
            $lastGameLogId = $lastGameLog?->id ?? 0;
            $liveGames = $contest->liveCricketGameSchedules()->whereNotIn('id', $gamesLoaded)->get();
            foreach ($liveGames as $liveGame) {
                $this->createCricketGameStatsService->handle($liveGame);
                $gamesLoaded[] = $liveGame->id;
            }
            $unconfirmedGames = $contest->unconfirmedCricketGameSchedules()->whereNotIn('id', $gamesLoaded)->get();
            foreach ($unconfirmedGames as $unconfirmedGame) {
                if ($unconfirmedGame->hasFinalBox() && $unconfirmedGame->updated_at < date('Y-m-d H:i:s', time() - CricketGameScheduleConst::CONFIRM_STATS_DELAY)) {
                    $this->confirmCricketGameStatsService->handle($unconfirmedGame);
                    $gamesLoaded[] = $unconfirmedGame->id;
                    $gamesConfirmed[] = $unconfirmedGame->id;
                }
            }
            if ($this->hasNewGameLogs($contest->id, $lastGameLogId, $cricketGameLogRepository) && !empty($gamesConfirmed)) {
                $this->calculateContestService->handle($contest);
            }
        }
    }

    private function hasNewGameLogs(int $contestId, int $lastGameLogId, CricketGameLogRepository $cricketGameLogRepository): bool
    {
        $gameLog = $cricketGameLogRepository->getLastGameLogByContestId($contestId);
        if ($gameLog && $gameLog->id > $lastGameLogId) {
            return true;
        }

        return false;
    }
}
