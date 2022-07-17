<?php

namespace App\Services;

use App\Exceptions\GameLogServiceException;
use App\Models\Contests\Contest;
use App\Repositories\Cricket\CricketGameLogRepository;
use App\Repositories\Soccer\SoccerGameLogRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class GameLogService
{
    public function __construct(
        private readonly CricketGameLogRepository $cricketGameLogRepository,
        private readonly SoccerGameLogRepository $soccerGameLogRepository
    ) {
    }

    /**
     * @throws GameLogServiceException
     */
    public function getGameLogs(Contest $contest): Collection
    {
        if ($contest->isSportSoccer()) {
            return $this->soccerGameLogRepository->getGameLogsByContestId($contest->id);
        }

        if ($contest->isSportCricket()) {
            return $this->cricketGameLogRepository->getGameLogsByContestId($contest->id);
        }

        throw new GameLogServiceException('Could not find game logs for this sport', Response::HTTP_NOT_FOUND);
    }
}
