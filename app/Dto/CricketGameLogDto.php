<?php

namespace App\Dto;

class CricketGameLogDto
{
    public ?int $id;
    public int $gameScheduleId;
    public int $unitId;
    public int $actionPointId;
    public float $value;
    public ?string $createdAt;
    public ?string $updatedAt;
}
