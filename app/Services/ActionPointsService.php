<?php

namespace App\Services;

use App\Enums\SportIdEnum;
use App\Repositories\ActionPointRepository;

class ActionPointsService
{
    public function __construct(private readonly ActionPointRepository $actionPointRepository)
    {
    }

    public function getMappedActionPoints(): array
    {
        return $this->actionPointRepository->getListBySportId(SportIdEnum::cricket)->mapWithKeys(function ($item, $key) {
            $values = json_decode($item['values'], true);

            return [$item['name'] => $values];
        })->toArray();
    }
}
