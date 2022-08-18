<?php

namespace App\Models;

class PrizePlace
{
    public ?int $places = null;
    public ?float $prize = null;
    public ?float $voucher = null;
    public ?int $badgeId = null;
    public ?int $numBadges = null;
    public array $winners = [];
    public ?int $from = null;
    public ?int $to = null;
}
