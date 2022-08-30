<?php

namespace App\Mappers\Pusher;

use App\Models\Contests\ContestUser;
use App\Models\PrizePlace;
use Pusher\Dto\PrizePlaceDto;

class PrizePlaceMapper
{
    public function __construct(private readonly ContestUserMapper $contestUserMapper)
    {
    }

    public function map(PrizePlace $prizePlace): PrizePlaceDto
    {
        $prizePlaceDto = new PrizePlaceDto();
        $contestUsers = [];

        $prizePlaceDto->places = $prizePlace->places;
        $prizePlaceDto->prize = $prizePlace->prize;
        $prizePlaceDto->voucher = $prizePlace->voucher;
        $prizePlaceDto->badgeId = $prizePlace->badgeId;
        $prizePlaceDto->numBadges = $prizePlace->numBadges;
        $prizePlaceDto->from = $prizePlace->from;
        $prizePlaceDto->to = $prizePlace->to;

        array_map(function (ContestUser $contestUser) use (&$contestUsers) {
            $contestUsers[] = $this->contestUserMapper->map($contestUser);
        }, $prizePlace->winners);

        $prizePlaceDto->winners = $contestUsers;

        return $prizePlaceDto;
    }
}
