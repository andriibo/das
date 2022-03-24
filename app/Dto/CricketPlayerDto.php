<?php

namespace App\Dto;

use App\Enums\CricketPlayerFeedTypeEnum;
use App\Enums\CricketPlayerInjuryStatusEnum;
use App\Enums\CricketPlayerSportEnum;

class CricketPlayerDto
{
    public int $id;
    public CricketPlayerFeedTypeEnum $feedType;
    public int $feedId;
    public CricketPlayerSportEnum $sport;
    public string $firstName;
    public string $lastName;
    public ?string $photo;
    public CricketPlayerInjuryStatusEnum $injuryStatus;
    public float $salary;
    public float $autoSalary;
    public float $totalFantasyPoints;
    public float $totalFantasyPointsPerGame;
}
