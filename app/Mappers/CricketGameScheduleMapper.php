<?php

namespace App\Mappers;

use App\Dto\CricketGameScheduleDto;
use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsFakeEnum;
use App\Enums\CricketGameSchedule\IsSalaryAvailableEnum;
use App\Enums\CricketGameSchedule\StatusEnum;
use App\Enums\CricketGameSchedule\TypeEnum;
use App\Enums\FeedTypeEnum;
use App\Repositories\CricketTeamRepository;

class CricketGameScheduleMapper
{
    public function __construct(private readonly CricketTeamRepository $cricketTeamRepository)
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
        $cricketGameScheduleDto->hasFinalBox = $this->hasFinalBox($data['status']);
        $cricketGameScheduleDto->homeTeamScore = $data['localteam']['totalscore'];
        $cricketGameScheduleDto->awayTeamScore = $data['visitorteam']['totalscore'];
        $cricketGameScheduleDto->isFake = IsFakeEnum::no;
        $cricketGameScheduleDto->isSalaryAvailable = IsSalaryAvailableEnum::no;
        $cricketGameScheduleDto->feedType = FeedTypeEnum::goalserve;
        $cricketGameScheduleDto->status = StatusEnum::tryFrom($data['status']);
        $cricketGameScheduleDto->type = TypeEnum::tryFrom($data['type']);

        return $cricketGameScheduleDto;
    }

    private function getCricketTeamIdByFeedId(string $feedId): int
    {
        return $this->cricketTeamRepository->getByFeedId($feedId)->id;
    }

    private function generateGameDate(string $date, string $time): string
    {
        [$hours, $minutes] = explode(':', $time);
        $dateTime = new \DateTime($date);
        $dateTime->setTime($hours ?? 0, $minutes ?? 0);

        return $dateTime->format('Y-m-d H:i:s');
    }

    private function hasFinalBox(string $status): HasFinalBoxEnum
    {
        return StatusEnum::finished->value === $status
            ? HasFinalBoxEnum::yes
            : HasFinalBoxEnum::no;
    }
}
