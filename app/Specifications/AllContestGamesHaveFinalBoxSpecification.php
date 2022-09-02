<?php

namespace App\Specifications;

use App\Enums\CricketGameSchedule\StatusEnum;
use App\Helpers\GameStatusHelper;
use App\Models\Contests\Contest;

class AllContestGamesHaveFinalBoxSpecification
{
    public function isSatisfiedBy(Contest $contest): bool
    {
        if ($contest->isSportSoccer()) {
            foreach ($contest->soccerGameSchedules as $gameSchedule) {
                if (GameStatusHelper::isPostponed($gameSchedule->status)) {
                    continue;
                }
                if (!$gameSchedule->hasFinalBox()) {
                    return false;
                }
            }
        }

        if ($contest->isSportCricket()) {
            foreach ($contest->cricketGameSchedules as $gameSchedule) {
                if ($gameSchedule->status === StatusEnum::stumps->value) {
                    continue;
                }
                if (!$gameSchedule->hasFinalBox()) {
                    return false;
                }
            }
        }

        return true;
    }
}
