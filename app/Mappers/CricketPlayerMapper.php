<?php

namespace App\Mappers;

use App\Dto\CricketPlayerDto;
use App\Enums\CricketPlayer\InjuryStatusEnum;
use App\Enums\CricketPlayer\SportEnum;
use App\Enums\FeedTypeEnum;

class CricketPlayerMapper
{
    public function map(array $data): CricketPlayerDto
    {
        $cricketPlayerDto = new CricketPlayerDto();

        $cricketPlayerDto->feedType = FeedTypeEnum::goalserve;
        $cricketPlayerDto->feedId = $data['id'];
        $cricketPlayerDto->sport = SportEnum::cricket;
        $cricketPlayerDto->firstName = $data['name'] ?? '';
        $cricketPlayerDto->lastName = $data['name'] ?? '';
        $cricketPlayerDto->photo = $data['photo'] ?? null;
        $cricketPlayerDto->injuryStatus = InjuryStatusEnum::normal;

        return $cricketPlayerDto;
    }
}
