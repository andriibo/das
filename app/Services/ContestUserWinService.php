<?php

namespace App\Services;

use App\Enums\UserTransactions\StatusEnum;
use App\Enums\UserTransactions\TypeEnum;
use App\Exceptions\CancelUserTransactionServiceException;
use App\Exceptions\UpdateBalanceServiceException;
use App\Models\Contests\ContestUser;
use App\Repositories\ContestUserRepository;
use App\Repositories\UserTransactionRepository;

class ContestUserWinService
{
    public function __construct(
        private readonly ContestUserRepository $contestUserRepository,
        private readonly UserTransactionRepository $userTransactionRepository,
        private readonly CancelUserTransactionService $cancelUserTransactionService,
        private readonly UpdateBalanceService $updateBalanceService
    ) {
    }

    /* @throws CancelUserTransactionServiceException|UpdateBalanceServiceException */
    public function handle(ContestUser $contestUser, float $prize): bool
    {
        $isContestUserUpdated = $this->contestUserRepository->update($contestUser, [
            'is_winner' => 1,
            'prize' => $prize,
        ]);

        if (!$isContestUserUpdated) {
            return false;
        }

        $userTransaction = $this->userTransactionRepository->getContestWinTransactionByUserIdAndSubjectId($contestUser->user_id, $contestUser->id);
        $isCanceledTransaction = $this->cancelUserTransactionService->handle($userTransaction);

        if ($userTransaction && !$isCanceledTransaction) {
            return false;
        }

        if (!$this->createWinTransaction($contestUser, $prize)) {
            return false;
        }
        $this->updateBalanceService->updateBalance($contestUser->user, $prize);

        return true;
    }

    private function createWinTransaction(ContestUser $contestUser, float $prize): bool
    {
        $this->userTransactionRepository->create([
            'type' => TypeEnum::contestWin->value,
            'subject_id' => $contestUser->id,
            'user_id' => $contestUser->user_id,
            'status' => StatusEnum::success->value,
            'amount' => $prize,
        ]);
    }
}
