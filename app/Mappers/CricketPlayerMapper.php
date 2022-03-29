<?php

namespace App\Mappers;

use App\Dto\CricketPlayerDto;
use App\Enums\CricketFeedTypeEnum;
use App\Enums\CricketPlayerInjuryStatusEnum;
use App\Enums\CricketPlayerSportEnum;

class CricketPlayerMapper
{
    public function map(array $data): CricketPlayerDto
    {
        $cricketPlayerDto = new CricketPlayerDto();

        $cricketPlayerDto->feedType = CricketFeedTypeEnum::goalserve;
        $cricketPlayerDto->feedId = $data['id'];
        $cricketPlayerDto->sport = CricketPlayerSportEnum::cricket;
        $cricketPlayerDto->firstName = $data['name'] ?? '';
        $cricketPlayerDto->lastName = $data['name'] ?? '';
        $cricketPlayerDto->photo = $data['photo'] ?? null;
        $cricketPlayerDto->injuryStatus = CricketPlayerInjuryStatusEnum::normal;

        return $cricketPlayerDto;
    }
}
