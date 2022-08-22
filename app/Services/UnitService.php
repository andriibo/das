<?php

namespace App\Services;

use App\Exceptions\UnitServiceException;
use App\Models\Contests\ContestUnit;
use App\Models\Cricket\CricketUnit;
use App\Models\Soccer\SoccerUnit;
use App\Repositories\Cricket\CricketUnitRepository;
use App\Repositories\Soccer\SoccerUnitRepository;
use Illuminate\Http\Response;

class UnitService
{
    public function __construct(
        private readonly SoccerUnitRepository $soccerUnitRepository,
        private readonly CricketUnitRepository $cricketUnitRepository
    ) {
    }

    /**
     * @throws UnitServiceException
     */
    public function getUnit(ContestUnit $contestUnit): CricketUnit|SoccerUnit
    {
        if ($contestUnit->isSportSoccer()) {
            return $this->soccerUnitRepository->getUnitById($contestUnit->unit_id);
        }

        if ($contestUnit->isSportCricket()) {
            return $this->cricketUnitRepository->getUnitById($contestUnit->unit_id);
        }

        throw new UnitServiceException('Could not find unit for this sport', Response::HTTP_NOT_FOUND);
    }
}
