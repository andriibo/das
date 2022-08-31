<?php

namespace App\Services\Contest;

use App\Enums\Contests\StatusEnum;
use App\Exceptions\GetGameSchedulesServiceException;
use App\Models\Contests\Contest;
use App\Repositories\ContestRepository;
use App\Specifications\ContestCanBeCancelledSpecification;
use App\Specifications\ContestCanBeClosedSpecification;
use App\Specifications\ContestCanBeFinishedSpecification;
use App\Specifications\ContestCanBeStartedSpecification;

class ContestRunService
{
    public function __construct(
        private readonly ContestCanBeStartedSpecification $contestCanBeStartedSpecification,
        private readonly ContestCanBeFinishedSpecification $contestCanBeFinishedSpecification,
        private readonly ContestCanBeClosedSpecification $contestCanBeClosedSpecification,
        private readonly ContestCloseService $contestCloseService,
        private readonly ContestCanBeCancelledSpecification $contestCanBeCancelledSpecification,
        private readonly ContestCancelService $contestCancelService,
        private readonly ContestRepository $contestRepository
    ) {
    }

    /* @throws GetGameSchedulesServiceException */
    public function handle(Contest $contest): void
    {
        if ($this->contestCanBeStartedSpecification->isSatisfiedBy($contest)) {
            $this->start($contest);
        } elseif ($this->contestCanBeFinishedSpecification->isSatisfiedBy($contest)) {
            $this->finish($contest);
        } elseif ($this->contestCanBeClosedSpecification->isSatisfiedBy($contest)) {
            $this->contestCloseService->handle($contest);
        } elseif ($this->contestCanBeCancelledSpecification->isSatisfiedBy($contest)) {
            $this->contestCancelService->handle($contest);
        }
    }

    private function start(Contest $contest): void
    {
        $this->contestRepository->updateStatus($contest, StatusEnum::started);
    }

    private function finish(Contest $contest): void
    {
        $this->contestRepository->updateStatus($contest, StatusEnum::finished);
    }
}
