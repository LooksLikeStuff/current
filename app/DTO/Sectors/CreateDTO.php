<?php

namespace App\DTO\Sectors;

use Illuminate\Support\Collection;

class CreateDTO
{
    public function __construct(
        public readonly string $name,
    )
    {
    }

    public static function fromCollectionOrArray(Collection|array $options): self
    {
        if ($options instanceof Collection) $options = $options->toArray();

        return new self(
            name: $options['name'],
        );
    }
}
