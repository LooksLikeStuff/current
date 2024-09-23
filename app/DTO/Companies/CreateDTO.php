<?php

namespace App\DTO\Companies;

use Illuminate\Support\Collection;

class CreateDTO
{
    public function __construct(
        public readonly string $name,
        public readonly int $sectorId,
    )
    {
    }

    public static function fromCollectionOrArray(Collection|array $options): self
    {
        if ($options instanceof Collection) $options = $options->toArray();

        return new  self(
            name: $options['name'],
            sectorId: $options['sector_id'],
        );
    }
}

