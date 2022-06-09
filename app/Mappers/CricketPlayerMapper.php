<?php

namespace App\Mappers;

use App\Dto\CricketPlayerDto;
use App\Enums\CricketPlayer\InjuryStatusEnum;
use App\Enums\FeedTypeEnum;

class CricketPlayerMapper
{
    public function map(array $data): CricketPlayerDto
    {
        $cricketPlayerDto = new CricketPlayerDto();

        $cricketPlayerDto->feedType = FeedTypeEnum::goalserve;
        $cricketPlayerDto->feedId = $data['id'];
        $cricketPlayerDto->firstName = $data['name'] ?? '';
        $cricketPlayerDto->lastName = $data['name'] ?? '';
        $cricketPlayerDto->photo = $data['photo'] ?? null;
        $cricketPlayerDto->injuryStatus = InjuryStatusEnum::normal;
        $cricketPlayerDto->salary = $data['salary'] ?? null;
        $cricketPlayerDto->autoSalary = $data['auto_salary'] ?? null;

        return $cricketPlayerDto;
    }
}
