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
        private readonly CreateGameStatsService $createGameStatsService,
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
            $lastGameLogId = 0;
            $lastGameLog = $cricketGameLogRepository->getLastGameLogByContestId($contest->id);
            if ($lastGameLog) {
                $lastGameLogId = $lastGameLog->id;
            }
            $liveGames = $contest->liveCricketGameSchedules()->whereNotIn('id', $gamesLoaded)->get();
            foreach ($liveGames as $liveGame) {
                $this->createGameStatsService->handle($liveGame);
                $gamesLoaded[] = $liveGame->id;
            }
            $unconfirmedGames = $contest->unconfirmedCricketGameSchedules()->whereNotIn('id', $gamesLoaded)->get();
            foreach ($unconfirmedGames as $unconfirmedGame) {
                if ($unconfirmedGame->has_final_box && $unconfirmedGame->updated_at < date('Y-m-d H:i:s', time() - CricketGameScheduleConst::CONFIRM_STATS_DELAY)) {
                    $this->confirmCricketGameStatsService->handle($unconfirmedGame);
                    $gamesLoaded[] = $unconfirmedGame->id;
                    $gamesConfirmed[] = $unconfirmedGame->id;
                }
            }
            $lastGameLog = $cricketGameLogRepository->getLastGameLogByContestId($contest->id);
            if ($lastGameLog && $lastGameLog->id > $lastGameLogId && !empty($gamesConfirmed)) {
                $this->calculateContestService->handle($contest);
            }
        }
    }
}
