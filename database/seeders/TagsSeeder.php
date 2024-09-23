<?php

namespace Database\Seeders;

use App\DTO\Tags\CreateDTO;
use App\Services\CompanyService;
use App\Services\TagService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{

    public function __construct(
        private readonly TagService $service,
        private readonly CompanyService $companyService,
    )
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (CompaniesSeeder::COMPANIES as $company) {
            if ($company['tag']) {
                $options = [
                    'title' => $company['tag'],
                    'company_id' => $this->companyService->getByName($company['name'])->id,
                ];

                $this->service->updateOrCreate(CreateDTO::fromCollectionOrArray($options));
            }
        }
    }
}
