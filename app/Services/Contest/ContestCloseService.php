<?php

namespace App\Services\Contest;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;
use App\Repositories\ContestRepository;
use App\Services\CalculateContestService;
use Exception;
use Illuminate\Support\Facades\DB;

class ContestCloseService
{
    public function __construct(
        private readonly ContestRepository $contestRepository,
        private readonly CalculateContestService $calculateContestService,
        private readonly ContestAwardWinnersService $contestAwardWinnersService
    ) {
    }

    /*  @throws Exception */
    public function handle(Contest $contest): void
    {
        DB::beginTransaction();

        try {
            $this->contestRepository->updateStatus($contest, StatusEnum::closed);
            $this->calculateContestService->handle($contest);
            $this->contestAwardWinnersService->handle($contest);
        } catch (Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }
}
