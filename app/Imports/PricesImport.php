<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PricesImport implements ToArray, WithHeadingRow, WithCustomCsvSettings
{

    /**
    * @param array $array
    */
    public function array(array $array)
    {
        return [

        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ",",
        ];
    }
}
