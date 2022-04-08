<?php

namespace App\Dto;

use App\Enums\CricketUnitPositionEnum;

class CricketUnitDto
{
    public ?int $id;
    public int $teamId;
    public int $playerId;
    public ?CricketUnitPositionEnum $position;
    public float $salary;
    public float $autoSalary;
    public float $totalFantasyPoints;
    public float $totalFantasyPointsPerGame;
}
