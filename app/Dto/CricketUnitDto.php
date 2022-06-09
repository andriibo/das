<?php

namespace App\Dto;

use App\Enums\CricketUnit\PositionEnum;

class CricketUnitDto
{
    public ?int $id;
    public int $teamId;
    public int $playerId;
    public ?PositionEnum $position;
    public float $salary;
    public float $autoSalary;
    public ?float $fantasyPoints;
    public ?float $fantasyPointsPerGame;
}
