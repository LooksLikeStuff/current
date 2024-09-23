<?php

namespace App\Services;

use App\DTO\Companies\CreateDTO;
use App\Models\Company;

class CompanyService
{
    public function create(CreateDTO $DTO)
    {
        return Company::create([
            'name' => $DTO->name,
        ]);
    }

    public function updateOrCreate(CreateDTO $DTO)
    {
        return Company::updateOrCreate(
            [
                'name' => $DTO->name,
                'sector_id' => $DTO->sectorId,
            ]
        );
    }

    public function getByName(string $name)
    {
        return Company::where('name', $name)->first();
    }
}
