<?php

namespace App\Services\Contest;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;
use App\Repositories\ContestRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ContestCloseService
{
    public function __construct(
        private readonly ContestRepository $contestRepository
    ) {
    }

    /*  @throws Exception */
    public function handle(Contest $contest): void
    {
        DB::beginTransaction();

        try {
            $this->contestRepository->setStatusById($contest->id, StatusEnum::closed);

            $this->calcPlayerScores($contest);
        } catch (Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }

    public function calcPlayerScores(Contest $contest)
    {
    }
}
