<?php

namespace App\Const;

class CricketGameScheduleConst
{
    public const HAS_FINAL_BOX = true;
    public const HAS_NOT_FINAL_BOX = false;

    public const IS_DATA_CONFIRMED = true;
    public const IS_NOT_DATA_CONFIRMED = false;

    public const IS_FAKE = true;
    public const IS_NOT_FAKE = false;

    public const IS_SALARY_AVAILABLE = true;
    public const IS_NOT_SALARY_AVAILABLE = false;

    public const HAS_FINAL_BOX_OPTIONS = [
        self::HAS_FINAL_BOX,
        self::HAS_NOT_FINAL_BOX,
    ];

    public const IS_DATA_CONFIRMED_OPTIONS = [
        self::IS_DATA_CONFIRMED,
        self::IS_NOT_DATA_CONFIRMED,
    ];

    public const IS_FAKE_OPTIONS = [
        self::IS_FAKE,
        self::IS_NOT_FAKE,
    ];

    public const IS_SALARY_AVAILABLE_OPTIONS = [
        self::IS_SALARY_AVAILABLE,
        self::IS_NOT_SALARY_AVAILABLE,
    ];
}
