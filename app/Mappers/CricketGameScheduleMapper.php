<?php

namespace App\Mappers;

use App\Dto\CricketGameScheduleDto;
use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsFakeEnum;
use App\Enums\CricketGameSchedule\IsSalaryAvailableEnum;
use App\Enums\CricketGameSchedule\StatusEnum;
use App\Enums\CricketGameSchedule\TypeEnum;
use App\Enums\FeedTypeEnum;
use App\Exceptions\CricketGameScheduleException;
use App\Helpers\CricketGameScheduleHelper;
use App\Repositories\Cricket\CricketTeamRepository;

class CricketGameScheduleMapper
{
    public function __construct(private readonly CricketTeamRepository $cricketTeamRepository)
    {
    }

    /* @throws CricketGameScheduleException */
    public function map(array $data, int $leagueId): CricketGameScheduleDto
    {
        $status = StatusEnum::tryFrom($data['status']);
        if (!$status) {
            throw new CricketGameScheduleException('Invalid status in Game Schedule. ID game - ' . $data['id']);
        }

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
        $cricketGameScheduleDto->status = $status;
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
        return CricketGameScheduleHelper::isStatusLive($status)
            ? HasFinalBoxEnum::yes
            : HasFinalBoxEnum::no;
    }
}
