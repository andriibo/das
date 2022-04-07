<?php

namespace App\Mappers;

use App\Const\CricketGameScheduleConst;
use App\Dto\CricketGameScheduleDto;
use App\Enums\CricketFeedTypeEnum;
use App\Enums\CricketGameScheduleStatusEnum;
use App\Enums\CricketGameScheduleTypeEnum;
use App\Services\CricketTeamService;

class CricketGameScheduleMapper
{
    public function __construct(private readonly CricketTeamService $cricketTeamService)
    {
    }

    public function map(array $data, int $leagueId): CricketGameScheduleDto
    {
        $cricketGameScheduleDto = new CricketGameScheduleDto();

        $cricketGameScheduleDto->feedId = $data['id'];
        $cricketGameScheduleDto->leagueId = $leagueId;
        $cricketGameScheduleDto->homeTeamId = $this->getCricketTeamIdByFeedId($data['localteam']['id']);
        $cricketGameScheduleDto->awayTeamId = $this->getCricketTeamIdByFeedId($data['visitorteam']['id']);
        $cricketGameScheduleDto->gameDate = $this->generateGameDate($data['date'], $data['time']);
        $cricketGameScheduleDto->hasFinalBox = CricketGameScheduleConst::HAS_FINAL_BOX;
        $cricketGameScheduleDto->isDataConfirmed = CricketGameScheduleConst::IS_DATA_CONFIRMED;
        $cricketGameScheduleDto->homeTeamScore = $data['localteam']['totalscore'];
        $cricketGameScheduleDto->awayTeamScore = $data['visitorteam']['totalscore'];
        $cricketGameScheduleDto->dateUpdated = null;
        $cricketGameScheduleDto->isFake = CricketGameScheduleConst::IS_NOT_FAKE;
        $cricketGameScheduleDto->isSalaryAvailable = CricketGameScheduleConst::IS_NOT_SALARY_AVAILABLE;
        $cricketGameScheduleDto->feedType = CricketFeedTypeEnum::goalserve;
        $cricketGameScheduleDto->status = CricketGameScheduleStatusEnum::tryFrom($data['status']);
        $cricketGameScheduleDto->type = CricketGameScheduleTypeEnum::tryFrom($data['type']);

        return $cricketGameScheduleDto;
    }

    private function getCricketTeamIdByFeedId(string $feedId): int
    {
        return $this->cricketTeamService->getCricketTeamByFeedId($feedId)->id;
    }

    private function generateGameDate(string $date, string $time): string
    {
        [$hours, $minutes] = explode(':', $time);
        $dateTime = new \DateTime($date);
        $dateTime->setTime($hours ?? 0, $minutes ?? 0);

        return $dateTime->format('Y-m-d H:i:s');
    }
}
