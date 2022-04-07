<?php

namespace App\Dto;

class CricketUnitStatsDto
{
    public ?int $id;
    public int $gameScheduleId;
    public int $playerId;
    public int $teamId;
    public array $rawStats;
    public ?string $createdAt;
    public ?string $updatedAt;
}
