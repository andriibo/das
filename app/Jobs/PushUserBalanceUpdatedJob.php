<?php

namespace App\Jobs;

use App\Mappers\Pusher\UserBalanceMapper;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Pusher\Services\SendUserBalanceUpdateService;

class PushUserBalanceUpdatedJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function __construct(private readonly Authenticatable $user)
    {
    }

    public function handle(): void
    {
        /* @var UserBalanceMapper $userBalanceMapper */
        $userBalanceMapper = resolve(UserBalanceMapper::class);
        /* @var SendUserBalanceUpdateService $sendUserBalanceUpdateService */
        $sendUserBalanceUpdateService = resolve(SendUserBalanceUpdateService::class);

        $userBalanceDto = $userBalanceMapper->map($this->user);

        $sendUserBalanceUpdateService->handle($userBalanceDto, $this->user->id);
    }
}
