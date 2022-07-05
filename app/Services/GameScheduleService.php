<?php

namespace App\Services;

use App\Exceptions\GameScheduleServiceException;
use App\Models\Contests\Contest;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\Soccer\SoccerGameSchedule;
use App\Repositories\Cricket\CricketGameScheduleRepository;
use App\Repositories\Soccer\SoccerGameScheduleRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class GameScheduleService
{
    public function __construct(
        private readonly CricketGameScheduleRepository $cricketGameScheduleRepository,
        private readonly SoccerGameScheduleRepository $soccerGameScheduleRepository
    ) {
    }

    /**
     * @throws GameScheduleServiceException
     *
     * @return Collection|CricketGameSchedule[]|SoccerGameSchedule[]
     */
    public function getGameSchedules(Contest $contest): Collection
    {
        if ($contest->isSportSoccer()) {
            return $this->soccerGameScheduleRepository->getGameSchedulesByContestId($contest->id);
        }

        if ($contest->isSportCricket()) {
            return $this->cricketGameScheduleRepository->getGameSchedulesByContestId($contest->id);
        }

        throw new GameScheduleServiceException('Could not find game schedule for this sport', Response::HTTP_NOT_FOUND);
    }
}
