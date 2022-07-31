<?php

namespace App\Services\Cricket;

use App\Repositories\Cricket\CricketUnitRepository;

class UpdateCricketUnitStatusService
{
    public function __construct(
        private readonly CricketUnitRepository $cricketUnitRepository
    ) {
    }

    /**
     * @param int[] $cricketUnitIds
     */
    public function handle(int $teamId, array $cricketUnitIds): void
    {
        $this->cricketUnitRepository->setNotActiveByTeamId($teamId);
        $this->cricketUnitRepository->setActiveByIds($cricketUnitIds);
    }
}
