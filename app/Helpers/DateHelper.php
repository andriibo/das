<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function dateFormatMs(string $date): int
    {
        return Carbon::parse($date)->getTimestampMs();
    }
}
