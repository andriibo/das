<?php

namespace App\Helpers;

class GameStatusHelper
{
    public const S_FINAL_GAME = 'FULL-TIME';
    public const S_FINAL_SCHEDULE = 'FT';
    public const S_POSTPONED = 'POSTP';
    public const S_CANCELED = 'CANCL';
    public const S_ABANDONED = 'ABAN';
    public const S_AFTER_EXTRA_TIME = 'AET';
    public const S_TO_BE_ANNOUNCED = 'TBA';
    public const S_PENALTY = 'Pen.';

    public static function hasFinalBox($status): bool
    {
        return in_array(strtoupper($status), [self::S_FINAL_GAME, self::S_FINAL_SCHEDULE]);
    }

    public static function isPostponed($status): bool
    {
        return in_array(strtoupper($status), [self::S_POSTPONED, self::S_CANCELED, self::S_ABANDONED]);
    }

    public static function getList(): array
    {
        return [
            self::S_FINAL_GAME,
            self::S_FINAL_SCHEDULE,
            self::S_POSTPONED,
            self::S_CANCELED,
            self::S_ABANDONED,
            self::S_AFTER_EXTRA_TIME,
            self::S_TO_BE_ANNOUNCED,
            self::S_PENALTY,
        ];
    }
}
