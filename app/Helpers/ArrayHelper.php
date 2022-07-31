<?php

namespace App\Helpers;

class ArrayHelper
{
    /**
     * Sum values of corresponding keys from two or more arrays, values from later arrays are added to former array.
     */
    public static function sum(): array
    {
        $args = func_get_args();
        if (!count($args)) {
            return [];
        }
        if (1 == count($args)) {
            return $args[0];
        }
        [$ar1, $ar2] = $args;
        if (count($args) > 2) {
            $ar2 = call_user_func_array([ArrayHelper::class, 'sum'], array_slice($args, 1));
        }
        foreach ($ar2 as $key => $value) {
            if (isset($ar1[$key])) {
                $ar1[$key] += $value;
            } else {
                $ar1[$key] = $value;
            }
        }

        return $ar1;
    }
}
