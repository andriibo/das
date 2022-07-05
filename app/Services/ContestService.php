<?php

namespace App\Services;

use App\Calculators\PrizePlaceCalculator;
use App\Helpers\ContestHelper;
use App\Models\Contests\Contest;
use App\Models\PrizePlace;

class ContestService
{
    public function __construct(private readonly SitePreferenceService $sitePreferenceService)
    {
    }

    public function getContestTypes(): array
    {
        $types = ContestHelper::getContestTypes();

        return array_map(function ($value, $label) {
            return (object) [
                'value' => $value,
                'label' => $label,
            ];
        }, array_keys($types), $types);
    }

    public function getExpectedPayout(Contest $contest): float
    {
        $fee = $this->sitePreferenceService->getSiteFee($contest->company_take, $contest->type);
        $expectedPayout = $contest->expected_payout - $contest->expected_payout / 100 * $fee;

        return round($expectedPayout, 2);
    }

    public function getMaxPrizeBank(Contest $contest): float
    {
        if (null !== $contest->custom_prize_bank) {
            return round($contest->prize_bank, 2);
        }

        if ($contest->isPrizeBankInPercents()) {
            $bank = $contest->max_users * $contest->entry_fee;
            $fee = $this->sitePreferenceService->getSiteFee($contest->company_take, $contest->type);

            return $bank - $bank / 100 * $fee;
        }

        return round($contest->prize_bank, 2);
    }

    /**
     * @return PrizePlace[]
     */
    public function getPrizePlaces(Contest $contest): array
    {
        $contestUsers = collect();
        /*
         * If current contest has a status STATUS_FINISHED or STATUS_CLOSED,
         * show a list of winners near a place.
         * To do this need to get a list of participants and assign their names to appropriate places.
         */
        if ($contest->isStatusClosed()) {
            $contestUsers = $contest->contestUsers()
                ->orderBy('place')
                ->get()
            ;
        }

        $prizePlaceCalculator = new PrizePlaceCalculator();

        return $prizePlaceCalculator->handle($contest, $contestUsers);
    }
}
