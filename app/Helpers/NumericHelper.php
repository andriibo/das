<?php

namespace App\Helpers;

class NumericHelper
{
    public static function ffloor(float $value, int $decimals = 2): float
    {
        return floor($value * pow(10, $decimals)) / pow(10, $decimals);
    }
}
