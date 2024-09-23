<?php

namespace Database\Seeders;

use App\DTO\Companies\CreateDTO;
use App\Services\CompanyService;
use App\Services\SectorService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    public const COMPANIES = [
        [
            'name' => 'Лукойл',
            'sector' => 'Нефть и газ',
            'tag' => 'НК',
        ],
        [
            'name' => 'Сбербанк России',
            'sector' => 'Финансы',
            'tag' => null,
        ],
        [
            'name' => 'Газпром',
            'sector' => 'Нефть и газ',
            'tag' => null,
        ],
        [
            'name' => 'Норильский никель',
            'sector' => 'Материалы',
            'tag' => 'ГМК',
        ],
        [
            'name' => 'Татнефть',
            'sector' => 'Нефть и газ',
            'tag' => null,
        ],
        [
            'name' => 'НОВАТЭК',
            'sector' => 'Нефть и газ',
            'tag' => null,
        ],
        [
            'name' => 'Сургутнефтегаз',
            'sector' => 'Нефть и газ',
            'tag' => null,
        ],
        [
            'name' => 'Северсталь',
            'sector' => 'Материалы',
            'tag' => null,
        ],
        [
            'name' => 'Полюс',
            'sector' => 'Материалы',
            'tag' => null,
        ],
        [
            'name' => 'Роснефть',
            'sector' => 'Нефть и газ',
            'tag' => 'НК',
        ]
    ];

    public function __construct(
        private readonly CompanyService $service,
        private readonly SectorService $sectorService,
    )
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::COMPANIES as $company) {
            $company['sector_id'] = $this->sectorService->getByName($company['sector'])->id;

            $this->service->updateOrCreate(CreateDTO::fromCollectionOrArray($company));
        }
    }
}
