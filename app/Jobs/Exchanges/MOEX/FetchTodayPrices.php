<?php

namespace App\Jobs\Exchanges\MOEX;

use App\Http\Services\DateService;
use App\Requests\Exchanges\MOEX;
use App\Services\PriceService;
use App\Services\TickerService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchTodayPrices implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(MOEX $moex, TickerService $tickerService, PriceService $priceService): void
    {
        //skip weekends
        if (DateService::now()->isWeekend()) return;

        $tickers = $tickerService->getAll();
        $tickerNames = $tickers->pluck('name')->toArray();

        $prices = [];
        foreach ($moex->getTodayPrices() as $price) {
            if (is_null($price['close'])) continue;

            if (in_array($price['ticker'], $tickerNames)) {
                    $price['ticker_id'] = $tickers->where('name', $price['ticker'])->first()->id;
                    unset($price['ticker']);

                    $prices[] = $price;
            }
        }

        $priceService->upsert($prices);
    }
}
