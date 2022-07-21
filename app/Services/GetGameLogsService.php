<?php

namespace App\Services;

use App\Exceptions\GetGameLogsServiceException;
use App\Models\Contests\Contest;
use App\Repositories\Cricket\CricketGameLogRepository;
use App\Repositories\Soccer\SoccerGameLogRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class GetGameLogsService
{
    public function __construct(
        private readonly CricketGameLogRepository $cricketGameLogRepository,
        private readonly SoccerGameLogRepository $soccerGameLogRepository
    ) {
    }

    /**
     * @throws GetGameLogsServiceException
     */
    public function handle(Contest $contest): Collection
    {
        if ($contest->isSportSoccer()) {
            return $this->soccerGameLogRepository->getGameLogsByContestId($contest->id);
        }

        if ($contest->isSportCricket()) {
            return $this->cricketGameLogRepository->getGameLogsByContestId($contest->id);
        }

        throw new GetGameLogsServiceException('Could not find game logs for this sport', Response::HTTP_NOT_FOUND);
    }
}
