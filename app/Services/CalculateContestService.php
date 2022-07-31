<?php

namespace App\Services;

use App\Events\ContestUnitsUpdatedEvent;
use App\Events\ContestUpdatedEvent;
use App\Events\GameLogsUpdatedEvent;
use App\Helpers\ContestUnitHelper;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestUser;
use App\Repositories\ActionPointRepository;
use Illuminate\Support\Collection;

class CalculateContestService
{
    public function __construct(private readonly ActionPointRepository $actionPointRepository)
    {
    }

    public function handle(Contest $contest): void
    {
        $actionPoints = $this->actionPointRepository->getActionPoints($contest->id);
        foreach ($contest->contestUnits as $contestUnit) {
            $score = ContestUnitHelper::calculateScore($contestUnit, $actionPoints);
            $contestUnit->score = $score;
            $contestUnit->save();
        }
        $this->calculateTeamScores($contest->contestUsers);
        $this->calculateUserPlaces($contest);
        $this->sendPushEvents($contest);
    }

    /**
     * @param Collection|ContestUser[] $contestUsers
     */
    private function calculateTeamScores(Collection $contestUsers): void
    {
        foreach ($contestUsers as $contestUser) {
            $contestUser->team_score = $contestUser->contestUnits()->sum('score');
            $contestUser->save();
        }
    }

    private function calculateUserPlaces(Contest $contest): void
    {
        $place = 0;
        $prevTeamScore = null;
        /* @var $contestUser ContestUser */
        foreach ($contest->contestUsers()->orderByDesc('team_score')->get() as $contestUser) {
            if ($prevTeamScore !== $contestUser->team_score) {
                ++$place;
                $prevTeamScore = $contestUser->team_score;
            }
            $contestUser->place = $place;
            $contestUser->save();
        }
    }

    private function sendPushEvents(Contest $contest)
    {
        event(new ContestUpdatedEvent($contest));
        event(new GameLogsUpdatedEvent($contest));
        event(new ContestUnitsUpdatedEvent($contest));
    }
}
