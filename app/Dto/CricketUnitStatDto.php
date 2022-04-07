<?php

namespace App\Dto;

class CricketUnitStatDto
{
    public ?int $id;
    public int $gameScheduleId;
    public int $playerId;
    public int $teamId;
    public array $rawStat;
    public ?string $createdAt;
    public ?string $updatedAt;
}
