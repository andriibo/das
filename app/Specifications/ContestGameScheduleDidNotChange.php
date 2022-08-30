<?php

namespace App\Specifications;

use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;
use App\Services\GetGameSchedulesService;

class ContestGameScheduleDidNotChange
{
    public function __construct(private readonly GetGameSchedulesService $getGameSchedulesService)
    {
    }

    /* @throws GetGameSchedulesServiceException */
    public function isSatisfiedBy(Contest $contest): bool
    {
        $gameSchedules = $this->getGameSchedulesService->handle($contest);

        // todo check game status from feed (suspended, postponed ...)
        return $gameSchedules->count() === $contest->contestGames->count();
    }
}
