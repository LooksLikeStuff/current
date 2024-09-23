<?php

namespace App\Http\Services;

class TransliterationService
{
    private const TO_RU = [
        'f' => 'а', ',' => 'б', 'd' => 'в', 'u' => 'г', 'l' => 'д', 't' => 'е', '`' => 'ё',
        ';' => 'ж', 'p' => 'з', 'b' => 'и', 'q' => 'й', 'r' => 'к', 'k' => 'л', 'v' => 'м',
        'y' => 'н', 'j' => 'о', 'g' => 'п', 'h' => 'р', 'c' => 'с', 'n' => 'т', 'e' => 'у',
        'a' => 'ф', '[' => 'х', 'w' => 'ц', 'x' => 'ч', 'i' => 'ш', 'o' => 'щ', 'm' => 'ь',
        's' => 'ы', ']' => 'ъ', "'" => "э", '.' => 'ю', 'z' => 'я',

        'F' => 'А', '<' => 'Б', 'D' => 'В', 'U' => 'Г', 'L' => 'Д', 'T' => 'Е', '~' => 'Ё',
        ':' => 'Ж', 'P' => 'З', 'B' => 'И', 'Q' => 'Й', 'R' => 'К', 'K' => 'Л', 'V' => 'М',
        'Y' => 'Н', 'J' => 'О', 'G' => 'П', 'H' => 'Р', 'C' => 'С', 'N' => 'Т', 'E' => 'У',
        'A' => 'Ф', '{' => 'Х', 'W' => 'Ц', 'X' => 'Ч', 'I' => 'Ш', 'O' => 'Щ', 'M' => 'Ь',
        'S' => 'Ы', '}' => 'Ъ', '"' => 'Э', '>' => 'Ю', 'Z' => 'Я',

        '@' => '"', '#' => '№', '$' => ';', '^' => ':', '&' => '?', '/' => '.', '?' => ',',
    ];

    private const TO_EN = [
        'а' => 'f', 'б' => ',', 'в' => 'd', 'г' => 'u', 'д' => 'l', 'е' => 't', 'ё' => '`',
        'ж' => ';', 'з' => 'p', 'и' => 'b', 'й' => 'q', 'к' => 'r', 'л' => 'k', 'м' => 'v',
        'н' => 'y', 'о' => 'j', 'п' => 'g', 'р' => 'h', 'с' => 'c', 'т' => 'n', 'у' => 'e',
        'ф' => 'a', 'х' => '[', 'ц' => 'w', 'ч' => 'x', 'ш' => 'i', 'щ' => 'o', 'ь' => 'm',
        'ы' => 's', 'ъ' => ']', 'э' => "'", 'ю' => '.', 'я' => 'z',

        'А' => 'F', 'Б' => '<', 'В' => 'D', 'Г' => 'U', 'Д' => 'L', 'Е' => 'T', 'Ё' => '~',
        'Ж' => ':', 'З' => 'P', 'И' => 'B', 'Й' => 'Q', 'К' => 'R', 'Л' => 'K', 'М' => 'V',
        'Н' => 'Y', 'О' => 'J', 'П' => 'G', 'Р' => 'H', 'С' => 'C', 'Т' => 'N', 'У' => 'E',
        'Ф' => 'A', 'Х' => '{', 'Ц' => 'W', 'Ч' => 'X', 'Ш' => 'I', 'Щ' => 'O', 'Ь' => 'M',
        'Ы' => 'S', 'Ъ' => '}', 'Э' => '"', 'Ю' => '>', 'Я' => 'Z',

        '"' => '@', '№' => '#', ';' => '$', ':' => '^', '?' => '&', '.' => '/', ',' => '?',
    ];

    private const MATCHES_RU = [
        'f' => 'ф', ',' => ',', 'd' => 'д', 'u' => 'ю', 'l' => 'л', 't' => 'т', '`' => '`',
        ';' => ';', 'p' => 'п', 'b' => 'б', 'q' => 'к', 'r' => 'р', 'k' => 'к', 'v' => 'в',
        'y' => 'у', 'j' => 'ж', 'g' => 'г', 'h' => 'х', 'c' => 'с', 'n' => 'н', 'e' => 'е',
        'a' => 'а', '[' => '[', 'w' => 'в', 'x' => 'х', 'i' => 'и', 'o' => 'о', 'm' => 'м',
        's' => 'с', ']' => ']', "'" => "'", '.' => '.', 'z' => 'з',

        'F' => 'Ф', '<' => '<', 'D' => 'Д', 'U' => 'Ю', 'L' => 'Л', 'T' => 'Т', '~' => '~',
        ':' => ':', 'P' => 'Р', 'B' => 'Б', 'Q' => 'К', 'R' => 'Р', 'K' => 'К', 'V' => 'В',
        'Y' => 'У', 'J' => 'Ж', 'G' => 'Г', 'H' => 'Х', 'C' => 'С', 'N' => 'Н', 'E' => 'Е',
        'A' => 'А', '{' => '{', 'W' => 'В', 'X' => 'Х', 'I' => 'И', 'O' => 'О', 'M' => 'М',
        'S' => 'С', '}' => '}', '"' => '"', '>' => '>', 'Z' => 'З',

        '@' => '"', '#' => '№', '$' => ';', '^' => ':', '&' => '?', '/' => '.', '?' => ',',
    ];


    public static function convertAll(array $strings): array
    {
        $translatedWords = [];
        //convert every word to other languages
        foreach ($strings as $string) {
            $translatedWords[] = self::convertToRu($string);
            $translatedWords[] = self::convertToEn($string);
            $translatedWords[] = self::convertToRuMatches($string);
        }

        return $translatedWords;
    }

    public static function convertToRu(string $str, bool $register = true): string
    {
         if (! $register) {
             $str = mb_strtolower($str);
         }

        return self::convert($str, self::TO_RU);
    }

    public static function convertToEn(string $str, bool $register = true): string
    {
        if (! $register) {
            $str = mb_strtolower($str);
        }

        return self::convert($str, self::TO_EN);
    }

    public static function convertToRuMatches(string $str, bool $register = true): string
    {
        if (! $register) {
            $str = mb_strtolower($str);
        }

        return self::convert($str, self::MATCHES_RU);
    }

    private static function convert($str, $lang): string
    {
        $convertedStr = '';
        foreach (mb_str_split($str) as $symbol) {
            if ($symbol != ' ') {
                $symbol = $lang[$symbol] ?? $symbol;
            }
            $convertedStr .= $symbol;
        }

        return $convertedStr;
    }
}
