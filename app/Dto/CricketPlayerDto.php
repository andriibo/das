<?php

namespace App\Dto;

use App\Enums\CricketPlayer\InjuryStatusEnum;
use App\Enums\CricketPlayer\SportEnum;
use App\Enums\FeedTypeEnum;

class CricketPlayerDto
{
    public ?int $id;
    public FeedTypeEnum $feedType;
    public int $feedId;
    public SportEnum $sport;
    public string $firstName;
    public string $lastName;
    public ?string $photo;
    public InjuryStatusEnum $injuryStatus;
    public ?float $salary;
    public ?float $autoSalary;
    public ?float $totalFantasyPoints;
    public ?float $totalFantasyPointsPerGame;
}
