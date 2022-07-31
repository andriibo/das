<?php

namespace App\Dto;

use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Enums\CricketGameSchedule\IsFakeEnum;
use App\Enums\CricketGameSchedule\IsSalaryAvailableEnum;
use App\Enums\CricketGameSchedule\StatusEnum;
use App\Enums\CricketGameSchedule\TypeEnum;
use App\Enums\FeedTypeEnum;

class CricketGameScheduleDto
{
    public ?int $id;
    public int $feedId;
    public int $leagueId;
    public int $homeTeamId;
    public int $awayTeamId;
    public string $gameDate;
    public HasFinalBoxEnum $hasFinalBox;
    public IsDataConfirmedEnum $isDataConfirmed;
    public string $homeTeamScore;
    public string $awayTeamScore;
    public IsFakeEnum $isFake;
    public IsSalaryAvailableEnum $isSalaryAvailable;
    public FeedTypeEnum $feedType;
    public ?StatusEnum $status;
    public TypeEnum $type;
    public ?string $createdAt;
    public ?string $updatedAt;
}
