<?php

namespace App\Services\Contest;

use App\Enums\UserTransactions\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Exceptions\ContestUserCancelServiceException;
use App\Exceptions\UpdateBalanceServiceException;
use App\Models\Contests\ContestUser;
use App\Repositories\UserTransactionRepository;
use App\Services\UpdateBalanceService;

class ContestUserCancelService
{
    public function __construct(
        private readonly UserTransactionRepository $userTransactionRepository,
        private readonly UpdateBalanceService $updateBalanceService
    ) {
    }

    /* @throws ContestUserCancelServiceException|UpdateBalanceServiceException */
    public function handle(ContestUser $contestUser): bool
    {
        $terminatedTransaction = $this->userTransactionRepository->getContestTerminatedTransactionByUserIdAndSubjectId($contestUser->user_id, $contestUser->id);

        if ($terminatedTransaction) {
            throw new ContestUserCancelServiceException('Terminate transaction already exists.');
        }

        $enterTransaction = $this->userTransactionRepository->getContestEnterTransactionByUserIdAndSubjectId($contestUser->user_id, $contestUser->id);

        if (!$enterTransaction) {
            throw new ContestUserCancelServiceException('Enter contest transaction not found.');
        }

        if (!$this->createContestCancelTransaction($contestUser, $enterTransaction->amount)) {
            return false;
        }

        $this->updateBalanceService->updateBalance($contestUser->user, $enterTransaction->amount);

        return true;
    }

    private function createContestCancelTransaction(ContestUser $contestUser, float $amount): bool
    {
        $this->userTransactionRepository->create([
            'type' => TypeEnum::contestCancel->value,
            'subject_id' => $contestUser->id,
            'user_id' => $contestUser->user_id,
            'status' => StatusEnum::success->value,
            'amount' => $amount,
        ]);
    }
}
