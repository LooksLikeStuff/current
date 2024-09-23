<?php

namespace App\Enums;

enum Period: int
{
    case DAY = 1;
    case WEEK = 7;
    case MONTH = 30;
    case YEAR = 365;
    case ALL = -1;
    public static function getCaseNames(): array
    {
        $names = [];
        foreach (self::cases() as $case) {
            $names[] = $case->name;
        }

        return $names;
    }
}
