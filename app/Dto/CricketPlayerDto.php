<?php

namespace App\Dto;

use App\Enums\CricketPlayerFeedTypeEnum;
use App\Enums\CricketPlayerInjuryStatusEnum;
use App\Enums\CricketPlayerSportIdEnum;

class CricketPlayerDto
{
    public int $id;
    public CricketPlayerFeedTypeEnum $feedType;
    public int $feedId;
    public CricketPlayerSportIdEnum $sportId;
    public string $firstName;
    public string $lastName;
    public ?string $imageName;
    public CricketPlayerInjuryStatusEnum $injuryStatus;
    public float $salary;
    public float $autoSalary;
    public float $totalFantasyPoints;
    public float $totalFantasyPointsPerGame;
}
