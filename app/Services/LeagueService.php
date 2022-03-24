<?php

namespace App\Services;

use App\Enums\LeagueSportIdEnum;
use App\Models\League;
use App\Repositories\LeagueRepository;
use Illuminate\Support\Collection;

class LeagueService
{
    public function __construct(private readonly LeagueRepository $leagueRepository)
    {
    }

    /**
     * @return Collection|League[]
     */
    public function getListBySportId(LeagueSportIdEnum $sportIdEnum): Collection
    {
        return $this->leagueRepository->getListBySportId($sportIdEnum);
    }
}
