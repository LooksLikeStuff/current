<?php

namespace Database\Seeders;

use App\DTO\Users\CreateDTO;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function __construct(
        private readonly UserService $service,
    )
    {
    }

    private const EMAILS = [
        'test@gmail.com',
        'integralik@gmail.com',
        'sergey@capitalspace.ru',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            'name' => fake()->name(),
            'password' => bcrypt('quicktum'), // password
        ];

        foreach (self::EMAILS as $email) {
            $options['email'] = $email;
            $this->service->updateOrCreate(CreateDTO::fromCollectionOrArray($options));
        }
    }
}
