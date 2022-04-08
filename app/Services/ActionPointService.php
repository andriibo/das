<?php

namespace App\Services;

use App\Enums\SportIdEnum;
use App\Models\League;
use App\Repositories\ActionPointRepository;
use Illuminate\Database\Eloquent\Collection;

class ActionPointService
{
    public function __construct(private readonly ActionPointRepository $actionPointRepository)
    {
    }

    /**
     * @return Collection|League[]
     */
    public function getListBySportId(SportIdEnum $sportIdEnum): Collection
    {
        return $this->actionPointRepository->getListBySportId($sportIdEnum);
    }
}
