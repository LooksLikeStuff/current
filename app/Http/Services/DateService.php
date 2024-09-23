<?php

namespace App\Http\Services;

use Carbon\Carbon;

class DateService
{
    public const TIMEZONE = 'Europe/Moscow';
    public const DATETIME_FORMAT_FOR_PRINT = 'j F, Y';
    public const HTML_DATE_FORMAT = 'Y-m-d';

    public const DEFAULT_DATE_FORMAT = 'd.m.Y';

    public const DAY_MONTH_DATE_FORMAT = 'd.m';

    public const MONTH_YEAR_DATE_FORMAT = 'm.Y';

    public static function parse($time = null): Carbon
    {
        if (is_null($time)) return self::now();

        return Carbon::parse($time,self::TIMEZONE);
    }

    public static function now(): Carbon
    {
        return Carbon::now(self::TIMEZONE);
    }
    public static function getStartOfWeek(): Carbon
    {
        return self::now()->startOfWeek();
    }

    public static function yesterday()
    {
        return Carbon::yesterday(self::TIMEZONE);
    }

    public static function today()
    {
        return Carbon::today(self::TIMEZONE);
    }

    public function getEndOfWeek(): Carbon
    {
        return self::now()->endOfWeek();
    }

    public static function formatForPrint($time): string
    {
        return self::parse($time)->translatedFormat(self::DATETIME_FORMAT_FOR_PRINT);
    }

    public static function todayDate(): string
    {
        return self::today()->toDateString();
    }

    public static function getOnlyDateForHtml($time = null): string
    {
        return self::parse($time)->format(self::HTML_DATE_FORMAT);
    }

    public static function getDefaultFormat($time): string
    {
        return self::parse($time)->format(self::DEFAULT_DATE_FORMAT);
    }

    public static function startOfWeekFormatDate($time = null)
    {
        return self::parse($time)->startOfWeek()->format(self::DAY_MONTH_DATE_FORMAT);
    }

    public static function endOfWeekFormatDate($time = null)
    {
        return self::parse($time)->endOfWeek()->format(self::DAY_MONTH_DATE_FORMAT);
    }

    public static function startOfMonthFormatDate($time = null)
    {
        return self::parse($time)->startOfMonth()->format(self::DEFAULT_DATE_FORMAT);
    }

    public static function endOfMonthFormatDate($time = null)
    {
        return self::parse($time)->endOfMonth()->format(self::DEFAULT_DATE_FORMAT);
    }

    public static function startOfYearFormatDate($time = null) {
        return self::startOfYear($time)->format(self::MONTH_YEAR_DATE_FORMAT);
    }

    public static function endOfYearFormatDate($time = null) {
        return self::parse($time)->endOfYear()->format(self::MONTH_YEAR_DATE_FORMAT);
    }

    public static function format($time = null, $format = self::DEFAULT_DATE_FORMAT)
    {
        return self::parse($time)->format($format);
    }

    public static function startOfYear($time = null)
    {
        return self::parse($time)->startOfYear();
    }

}
