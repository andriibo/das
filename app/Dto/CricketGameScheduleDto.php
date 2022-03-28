<?php

namespace App\Dto;

use App\Enums\CricketFeedTypeEnum;
use App\Enums\CricketGameScheduleStatusEnum;
use App\Enums\CricketGameScheduleTypeEnum;

class CricketGameScheduleDto
{
    public ?int $id;
    public int $feedId;
    public int $leagueId;
    public int $homeCricketTeamId;
    public int $awayCricketTeamId;
    public string $gameDate;
    public bool $hasFinalBox;
    public int $isDataConfirmed;
    public string $homeCricketTeamScore;
    public string $awayCricketTeamScore;
    public ?string $dateUpdated;
    public bool $isFake;
    public bool $isSalaryAvailable;
    public CricketFeedTypeEnum $feedType;
    public CricketGameScheduleStatusEnum $status;
    public CricketGameScheduleTypeEnum $type;
}