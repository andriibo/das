<?php

namespace App\Mappers\Pusher;

use App\Exceptions\UnitServiceException;
use App\Helpers\FileHelper;
use App\Models\Contests\ContestUnit;
use App\Services\UnitService;
use FantasySports\SportConfig\Exceptions\SportConfigFactoryException;
use FantasySports\SportConfig\Factories\SportConfigFactory;
use Pusher\Dto\ContestUnitDto;

class ContestUnitMapper
{
    public function __construct(private readonly PositionMapper $positionMapper)
    {
    }

    /**
     * @throws SportConfigFactoryException
     * @throws UnitServiceException
     */
    public function map(ContestUnit $contestUnit): ContestUnitDto
    {
        $contestUnitDto = new ContestUnitDto();

        /* @var $unitService UnitService */
        $unitService = resolve(UnitService::class);
        $unit = $unitService->getUnit($contestUnit);
        $sportConfig = SportConfigFactory::getConfig($contestUnit->sport_id);

        $contestUnitDto->id = $contestUnit->id;
        $contestUnitDto->playerId = $unit->player->id;
        $contestUnitDto->totalFantasyPointsPerGame = (float) $unit->player->total_fantasy_points_per_game;
        $contestUnitDto->salary = (float) $contestUnit->salary;
        $contestUnitDto->score = (float) $contestUnit->score;
        $contestUnitDto->fullname = $unit->player->getFullName();
        $contestUnitDto->photo = FileHelper::getPublicUrl($unit->player->photo);
        $contestUnitDto->teamId = $contestUnit->team_id;
        $contestUnitDto->sportId = $contestUnit->sport_id;

        $position = $this->positionMapper->map($sportConfig->positions[$unit->position]);

        $contestUnitDto->position = $position;

        return $contestUnitDto;
    }
}
