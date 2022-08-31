<?php

namespace App\Services\Contest;

use App\Enums\Contests\StatusEnum;
use App\Models\Contests\Contest;
use App\Repositories\ContestRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class ContestCancelService
{
    public function __construct(
        private readonly ContestRepository $contestRepository,
        private readonly ContestUserCancelService $contestUserCancelService,
    ) {
    }

    /*  @throws Exception */
    public function handle(Contest $contest): void
    {
        DB::beginTransaction();

        try {
            $this->contestRepository->updateStatus($contest, StatusEnum::cancelled);

            foreach ($contest->contestUsers as $contestUser) {
                $this->contestUserCancelService->handle($contestUser);
            }
        } catch (Exception $e) {
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }
}
