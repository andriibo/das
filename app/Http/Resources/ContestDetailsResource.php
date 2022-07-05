<?php

namespace App\Http\Resources;

use App\Helpers\DateHelper;
use App\Services\ContestService;
use App\Services\GameScheduleService;
use Illuminate\Http\Resources\Json\JsonResource;

class ContestDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        /* @var $contestService ContestService
        * @var $gameScheduleService GameScheduleService */
        $contestService = resolve(ContestService::class);
        $gameScheduleService = resolve(GameScheduleService::class);

        return [
            'id' => $this->id,
            'status' => $this->status,
            'type' => $this->type,
            'contestType' => $this->contest_type,
            'expectedPayout' => $contestService->getExpectedPayout($this->resource),
            'isPrizeInPercents' => $this->is_prize_in_percents,
            'maxEntries' => $this->entry_limit,
            'maxUsers' => $this->max_users,
            'minUsers' => $this->min_users,
            'startDate' => DateHelper::dateFormatMs($this->start_date),
            'endDate' => DateHelper::dateFormatMs($this->end_date),
            'details' => $this->details,
            'entryFee' => (float) $this->entry_fee,
            'salaryCap' => $this->salary_cap,
            'prizeBank' => (float) $this->prize_bank,
            'prizeBankType' => $this->prize_bank_type,
            'customPrizeBank' => (float) $this->custom_prize_bank,
            'maxPrizeBank' => $contestService->getMaxPrizeBank($this->resource),
            'suspended' => $this->suspended,
            'name' => $this->title,
            'league' => new LeagueResource($this->league),
            'contestUsers' => ContestUserResource::collection($this->contestUsers),
            'games' => GameScheduleResource::collection($gameScheduleService->getGameSchedules($this->resource)),
            'prizes' => PrizePlaceResource::collection($contestService->getPrizePlaces($this->resource)),
            'scoring' => ActionPointResource::collection($this->actionPoints),
        ];
    }
}
