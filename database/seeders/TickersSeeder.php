<?php

namespace Database\Seeders;

use App\DTO\Tickers\TickerDTO;
use App\Services\CompanyService;
use App\Services\TickerService;
use Illuminate\Database\Seeder;

class TickersSeeder extends Seeder
{
    private const TICKERS = ['LKOH', 'SBER', 'GAZP', 'GMKN', 'TATN', 'NVTK', 'SNGSP', 'CHMF', 'PLZL', 'ROSN'];

    public function __construct(
        private readonly TickerService $service,
        private readonly CompanyService $companyService,
    )
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::TICKERS as $key => $ticker)
        {
            $options = [
                'name' => $ticker,
                'company_id' => $this->companyService->getByName(CompaniesSeeder::COMPANIES[$key]['name'])->id,
            ];

            $this->service->updateOrCreate(TickerDTO::fromCollectionOrArray($options));
        }
    }
}
