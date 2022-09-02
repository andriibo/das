<?php

namespace App\Helpers;

use App\Enums\GameStatusEnum;

class GameStatusHelper
{
    public static function hasFinalBox($status): bool
    {
        return in_array(strtoupper($status), [GameStatusEnum::finalGame->value, GameStatusEnum::finalSchedule->value]);
    }

    public static function isPostponed($status): bool
    {
        return in_array(strtoupper($status), [
            GameStatusEnum::postponed->value,
            GameStatusEnum::canceled->value,
            GameStatusEnum::abandoned->value,
        ]);
    }

    public static function getList(): array
    {
        return [
            GameStatusEnum::finalGame->value,
            GameStatusEnum::finalSchedule->value,
            GameStatusEnum::postponed->value,
            GameStatusEnum::canceled->value,
            GameStatusEnum::abandoned->value,
            GameStatusEnum::afterExtraTime->value,
            GameStatusEnum::toBeAnnounced->value,
            GameStatusEnum::penalty->value,
        ];
    }
}
