<?php

namespace App\DTO\Tags;

use Illuminate\Support\Collection;

class CreateDTO
{
    public function __construct(
        public readonly int $companyId,
        public readonly string $title,
    )
    {
    }

    public static function fromCollectionOrArray(Collection|array $options): self
    {
        if ($options instanceof Collection) $options = $options->toArray();

        return new self(
            companyId: $options['company_id'],
            title: $options['title'],
        );
    }
}
