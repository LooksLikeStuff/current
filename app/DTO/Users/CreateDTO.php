<?php

namespace App\DTO\Users;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class CreateDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,

    )
    {
    }

    public static function fromCollectionOrArray(Collection|array $options): self
    {
        if ($options instanceof Collection) $options = $options->toArray();

        return new self(
            name: $options['name'],
            email: $options['email'],
            password: $options['password'],
        );
    }
}
