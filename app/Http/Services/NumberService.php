<?php

namespace App\Http\Services;

use Illuminate\Support\Number;

class NumberService
{
    public static function currency(int|float $number, string $in = 'RUB', string $locale = 'ru'): false|string
    {
        if ($number >= 0) return Number::currency($number, $in, $locale);
        else return '-' . Number::currency(abs($number), $in, $locale);
    }
}
