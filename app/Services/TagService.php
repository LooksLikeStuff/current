<?php

namespace App\Services;

use App\DTO\Tags\CreateDTO;
use App\Models\Tag;

class TagService
{
    public function updateOrCreate(CreateDTO $DTO)
    {
        $uniqueBy = [
            'company_id' => $DTO->companyId,
            'title' => $DTO->title,
        ];

        return Tag::updateOrCreate($uniqueBy,
        [
            'company_id' => $DTO->companyId,
            'title' => $DTO->title,
        ]);
    }
}
