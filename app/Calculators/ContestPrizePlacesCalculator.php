<?php

namespace App\Calculators;

use App\Models\Contests\Contest;
use App\Models\PrizePlace;
use Illuminate\Support\Arr;

trait ContestPrizePlacesCalculator
{
    /**
     * @return PrizePlace[]
     */
    private function calcPrizePlacesForContest(Contest $contest): array
    {
        $prizePlaces = [];

        foreach ($contest->prize_places as $item) {
            if (!$item instanceof PrizePlace) {
                $model = new PrizePlace();
                $model->places = Arr::get($item, 'places');
                $model->prize = Arr::get($item, 'prize');
                $item = $model;
            }
            if ($contest->isPrizeBankInPercents()) {
                $item->prize = round($contest->prize_bank / 100 * $item->prize, 2);
                $item->voucher = round($contest->prize_bank / 100 * $item->voucher, 2);
            }
            $prizePlaces[] = $item;
        }

        return $prizePlaces;
    }
}
