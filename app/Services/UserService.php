<?php

namespace App\Services;

use App\DTO\Users\CreateDTO;
use App\Models\User;

class UserService
{
    public function updateOrCreate(CreateDTO $DTO)
    {
        $uniqueBy = [
            'email' => $DTO->email,
        ];

        return User::updateOrCreate($uniqueBy,
            [
                'name' => $DTO->name,
                'email' => $DTO->email,
                'password' => $DTO->password,
            ]);
    }
}
