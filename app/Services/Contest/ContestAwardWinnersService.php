<?php

namespace App\Services\Contest;

use App\Enums\Contests\PrizeBankTypeEnum;
use App\Exceptions\ContestAwardWinnersServiceException;
use App\Helpers\NumericHelper;
use App\Models\Contests\Contest;
use App\Models\PrizePlace;
use App\Repositories\ContestUserRepository;
use App\Specifications\ContestStatusAllowsAwardsSpecification;

class ContestAwardWinnersService
{
    public function __construct(
        private readonly ContestStatusAllowsAwardsSpecification $contestStatusAllowsAwardsSpecification,
        private readonly ContestUserRepository $contestUserRepository,
        private readonly ContestUserWinService $contestUserWinService
    ) {
    }

    /**
     * @throws ContestAwardWinnersServiceException
     */
    public function handle(Contest $contest): void
    {
        if (!$this->contestStatusAllowsAwardsSpecification->isSatisfiedBy($contest)) {
            throw new ContestAwardWinnersServiceException('Contest status does not allow awards');
        }

        switch ($contest->prize_bank_type) {
            case PrizeBankTypeEnum::wta->value:
                $this->awardWTA($contest);

                break;

            case PrizeBankTypeEnum::topThree->value:
                $this->awardTopThree($contest);

                break;

            case PrizeBankTypeEnum::customPayout->value:
                $this->awardCustomPayout($contest);

                break;

            case PrizeBankTypeEnum::fiftyFifty->value:
                $this->award50($contest);

                break;

            default:
                throw new ContestAwardWinnersServiceException('Unknown bank type ' . $contest->prize_bank_type);
        }
    }

    public function normalizePrizePlaces(Contest $contest): array
    {
        /* @var $prizes PrizePlace[] */
        $prizes = [];

        foreach ($contest->prize_places as $prizePlace) {
            if ($contest->is_prize_in_percents) {
                $prizePlace->prize = round($contest->prize_bank / 100 * $prizePlace->prize, 2);
                $prizePlace->voucher = round($contest->prize_bank / 100 * $prizePlace->voucher, 2);
            }
            $prizes[] = $prizePlace;
        }

        switch (true) {
            case $contest->prize_bank_type === PrizeBankTypeEnum::topThree->value:
                $topThree = [];
                foreach ([50, 30, 20] as $prizePercent) {
                    $prizePlace = new PrizePlace();
                    $prizePlace->places = 1;
                    $prizePlace->prize = round($prizePlace->prize / 100 * $prizePercent, 2);
                    $prizePlace->voucher = round($prizePlace->voucher / 100 * $prizePercent, 2);
                    $topThree[] = $prizePlace;
                }
                $prizes = $topThree;

                break;

            case $contest->prize_bank_type === PrizeBankTypeEnum::fiftyFifty->value:
                $places = $contest->contestUsers()->max('place');
                $prizes[0]->places = $places > 1 ? floor($places / 2) : $places;

                break;
        }

        return $prizes;
    }

    /* @throws ContestAwardWinnersServiceException */
    protected function award50(Contest $contest): void
    {
        $prizePlaces = $this->normalizePrizePlaces($contest);
        if (!isset($prizePlaces[0])) {
            throw new ContestAwardWinnersServiceException('Invalid prize config ' . $contest->id);
        }
        $winners = $this->contestUserRepository->getContestWinners($contest->id, $prizePlaces[0]->places);
        $this->award($winners, $prizePlaces[0]->prize);
    }

    /*  @throws ContestAwardWinnersServiceException */
    private function awardWTA(Contest $contest): void
    {
        $prizePlaces = $this->normalizePrizePlaces($contest);
        if (!isset($prizePlaces[0])) {
            throw new ContestAwardWinnersServiceException('Invalid prize config ' . $contest->id);
        }
        $winners = $this->contestUserRepository->getContestWinners($contest->id, 1);
        $this->award($winners, $prizePlaces[0]->prize);
    }

    /* @throws ContestAwardWinnersServiceException */
    private function award(array $winners, float $prize): void
    {
        $numWinners = count($winners);
        if (!$numWinners) {
            return;
        }

        $prize = NumericHelper::ffloor($prize / $numWinners, 2);
        foreach ($winners as $winner) {
            if (!$this->contestUserWinService->handle($winner, $prize)) {
                throw new ContestAwardWinnersServiceException();
            }
        }
    }

    /* @throws ContestAwardWinnersServiceException */
    private function awardTopThree(Contest $contest): void
    {
        $prizePlaces = $this->expandPrizePlaces($contest);
        $winners = $this->contestUserRepository->getContestWinners($contest->id, 3);
        $groups = $winners->groupBy('place');

        foreach ($groups as $winners) {
            if (!$prizePlaces) {
                break;
            }
            $prize = array_sum(array_splice($prizePlaces, 0, count($winners)));
            $this->award($winners, $prize);
        }
    }

    private function expandPrizePlaces(Contest $contest): array
    {
        $places = [];
        $place = 1;
        foreach ($this->normalizePrizePlaces($contest) as $prizePlace) {
            $places = array_merge(
                $places,
                array_fill(
                    $place,
                    $prizePlace->places,
                    NumericHelper::ffloor($prizePlace->prize / $prizePlace->places, 2)
                )
            );
            $place += $prizePlace->places;
        }

        return $places;
    }

    /* @throws ContestAwardWinnersServiceException */
    private function awardCustomPayout(Contest $contest): void
    {
        $prizePlaces = $this->expandPrizePlaces($contest);
        $winners = $this->contestUserRepository->getContestWinners($contest->id, count($prizePlaces));
        $groups = $winners->groupBy('place');

        foreach ($groups as $winners) {
            if (!$prizePlaces) {
                break;
            }
            $prize = array_sum(array_splice($prizePlaces, 0, count($winners)));
            $this->award($winners, $prize);
        }
    }
}
