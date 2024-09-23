<?php
if (!function_exists('decline')) {
    function decline($expression, array $options)
    {
        $expr = abs((int)$expression) % 100;
        if (($expr > 10 && $expr < 20) || $expr % 10 == 0) {
            return $options[0];
        } elseif($expr % 10 == 1) {
            return $options[1];
        } elseif ($expr % 10 > 1 && $expr % 10 < 5) {
            return $options[2];
        } else {
            return $options[0];
        }

    }
}

if (!function_exists('str_display_urls')) {
    function str_display_urls(?string $str): ?string
    {
        //callback function
        function displayUrls($matches): string
        {
            return "<a href='$matches[0]' target='_blank'>" . preg_replace('#\bhttps?://#', '', $matches[0]) . "</a>";
        };

        $pattern = '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';

        return preg_replace_callback(pattern: $pattern, callback: 'displayUrls', subject: $str);
    }
}


if (!function_exists('format_number_to_ui')) {
    function format_number_to_ui(int|float $number,int $decimals = 0): string
    {
        return number_format($number, $decimals, ',', ' ');
    }
}

if (!function_exists('currency')) {
    function currency(int|float $number, string $in = 'RUB', string $locale = 'ru'): string
    {
        return \App\Http\Services\NumberService::currency($number, $in, $locale);
    }
}

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($text): string
    {
        return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
    }
}

if (!function_exists('is_float_not_equal_zero')) {
    function is_float_not_equal_zero(float $number): bool
    {
        return abs($number) != 0.00001;
    }
}

if (!function_exists('format_number_to_ui')) {
    function format_number_to_ui(int|float $number, int $decimals = 0): string
    {
        return number_format($number, $decimals, ',', ' ');
    }
}

