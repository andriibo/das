<?php

namespace App\Mappers\Pusher;

use App\Helpers\DateHelper;
use App\Models\ActionPoint;
use App\Models\Contests\Contest;
use App\Models\Contests\ContestUser;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\PrizePlace;
use App\Models\Soccer\SoccerGameSchedule;
use App\Services\ContestService;
use App\Services\GameScheduleService;
use Pusher\Dto\ContestDto;

class ContestMapper
{
    public function __construct(
        private readonly ContestService $contestService,
        private readonly GameScheduleService $gameScheduleService,
        private readonly LeagueMapper $leagueMapper,
        private readonly ContestUserMapper $contestUserMapper,
        private readonly GameScheduleMapper $gameScheduleMapper,
        private readonly PrizePlaceMapper $prizePlaceMapper,
        private readonly ActionPointMapper $actionPointMapper
    ) {
    }

    public function map(Contest $contest): ContestDto
    {
        $contestDto = new ContestDto();
        $contestUsers = $gameSchedules = $prizePlaces = $scoring = [];

        $contestDto->id = $contest->id;
        $contestDto->status = $contest->status;
        $contestDto->contestType = $contest->contest_type;
        $contestDto->expectedPayout = $this->contestService->getExpectedPayout($contest);
        $contestDto->isPrizeInPercents = $contest->is_prize_in_percents;
        $contestDto->maxEntries = $contest->entry_limit;
        $contestDto->maxUsers = $contest->max_users;
        $contestDto->minUsers = $contest->min_users;
        $contestDto->startDate = DateHelper::dateFormatMs($contest->start_date);
        $contestDto->endDate = DateHelper::dateFormatMs($contest->end_date);
        $contestDto->details = $contest->details;
        $contestDto->entryFee = (float) $contest->entry_fee;
        $contestDto->salaryCap = $contest->salary_cap;
        $contestDto->prizeBank = (float) $contest->prize_bank;
        $contestDto->prizeBankType = $contest->prize_bank_type;
        $contestDto->customPrizeBank = (float) $contest->custom_prize_bank;
        $contestDto->maxPrizeBank = $this->contestService->getMaxPrizeBank($contest);
        $contestDto->suspended = $contest->suspended;
        $contestDto->name = $contest->title;

        $contestDto->league = $this->leagueMapper->map($contest->league);

        $contest->contestUsers->map(function (ContestUser $contestUser) use (&$contestUsers) {
            $contestUsers[] = $this->contestUserMapper->map($contestUser);
        });

        $contestDto->contestUsers = $contestUsers;

        $gameScheduleList = $this->gameScheduleService->getGameSchedules($contest);

        $gameScheduleList->map(function (CricketGameSchedule|SoccerGameSchedule $gameSchedule) use (&$gameSchedules) {
            $gameSchedules[] = $this->gameScheduleMapper->map($gameSchedule);
        });

        $contestDto->games = $gameSchedules;

        $prizePlaceList = $this->contestService->getPrizePlaces($contest);

        array_map(function (PrizePlace $prizePlace) use (&$prizePlaces) {
            $prizePlaces[] = $this->prizePlaceMapper->map($prizePlace);
        }, $prizePlaceList);

        $contestDto->prizes = $prizePlaces;

        $contest->actionPoints->map(function (ActionPoint $actionPoint) use (&$scoring) {
            $scoring[] = $this->actionPointMapper->map($actionPoint);
        });

        $contestDto->scoring = $scoring;

        return $contestDto;
    }
}
