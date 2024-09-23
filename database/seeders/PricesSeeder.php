<?php

namespace Database\Seeders;

use App\Imports\PricesImport;
use App\Services\PriceService;
use App\Services\TickerService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class PricesSeeder extends Seeder
{
    public function __construct(
        private readonly TickerService $tickerService,
        private readonly PriceService $priceService,
    )
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->tickerService->getAll() as $ticker) {
            $filepath = 'quotes/' . mb_strtoupper($ticker->name) . '.csv';

            if (Storage::disk('local')->exists($filepath)) {
                $data = Excel::toArray(new PricesImport($ticker->id), $filepath, readerType: \Maatwebsite\Excel\Excel::CSV)[0] ?? [];

                $indexedData = [];
                foreach ($data as $item) {
                    $indexedData[] = [
                        'ticker_id' => $ticker->id,
                        'date' => $item['time'],
                        'open' => $item['open'],
                        'high' => $item['high'],
                        'low' => $item['low'],
                        'close' => $item['close'],
                    ];
                }

                $this->priceService->upsert($indexedData);
            }
        }

    }
}
