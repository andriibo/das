<?php

namespace App\Services;

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
        private readonly CancelUserTransactionService $cancelUserTransactionService
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

        if (!$isCanceledTransaction) {
            return false;
        }
//        $ut = new UserTransaction();
//        if (!$ut->win($this)) {
//            return false;
//        }
        return true;
    }
}
