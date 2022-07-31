<?php

namespace App\Dto;

class CricketGameStatsDto
{
    public ?int $id;
    public int $gameScheduleId;
    public array $rawStats;
    public ?string $createdAt;
    public ?string $updatedAt;
}
