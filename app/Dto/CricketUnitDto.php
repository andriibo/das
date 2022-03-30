<?php

namespace App\Dto;

use App\Enums\CricketUnitPositionEnum;

class CricketUnitDto
{
    public ?int $id;
    public int $cricketTeamId;
    public int $cricketPlayerId;
    public ?CricketUnitPositionEnum $position;
    public float $salary;
    public float $autoSalary;
    public float $totalFantasyPoints;
    public float $totalFantasyPointsPerGame;
}
