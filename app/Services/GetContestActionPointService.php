<?php

namespace App\Services;

use App\Models\ActionPoint;
use App\Repositories\ActionPointRepository;
use Illuminate\Support\Collection;

class GetContestActionPointService
{
    private static Collection $actionPoints;

    public function __construct(private readonly ActionPointRepository $actionPointRepository)
    {
        self::$actionPoints = Collection::empty();
    }

    public function handle(int $contestId, int $actionPointId): ActionPoint
    {
        if (self::$actionPoints->isEmpty()) {
            self::$actionPoints = $this->actionPointRepository->getActionPoints($contestId);
        }

        return self::$actionPoints->find($actionPointId);
    }
}
