<?php

namespace Database\Seeders;

use App\DTO\Sectors\CreateDTO;
use App\Services\SectorService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorsSeeder extends Seeder
{
    public const SECTORS = [
        ['name' => 'Нефть и газ'],
        ['name' => 'Финансы'],
        ['name' => 'Материалы'],
    ];

    public function __construct(
        private readonly SectorService $service,
    )
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::SECTORS as $sector) {
            $this->service->updateOrCreate(CreateDTO::fromCollectionOrArray($sector));
        }
    }
}
