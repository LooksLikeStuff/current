<?php

namespace App\Jobs\Exchanges\MOEX;

use AllowDynamicProperties;
use App\DTO\Logs\JobLogDTO;
use App\Http\Services\DateService;
use App\Requests\Exchanges\MOEX;
use App\Services\JobLogService;
use App\Services\PriceService;
use App\Services\TickerService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchPricesByDate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Carbon $date;

    /**
     * Create a new job instance.
     */
    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle(TickerService $tickerService, PriceService $priceService, MOEX $moex, JobLogService $jobLogService): void
    {
        $stringDate = $this->date->toDateString();
        $prices = $moex->getPricesByDate($this->date);
        $tickers = $tickerService->getAll();
        $tickerNames = $tickers->pluck('name')->toArray();

        $neededPrices = [];
        foreach ($prices as $price) {
            if (in_array($price['SECID'], $tickerNames)) {
                $neededPrices[] = [
                    'ticker_id' => $tickers->where('name', $price['SECID'])->first()->id,
                    'open' => $price['OPEN'],
                    'close' => $price['CLOSE'],
                    'low' => $price['LOW'] ?? null,
                    'high' => $price['HIGH'] ?? null,
                    'date' => $stringDate,
                ];
            }
        }

        $jobLogService->create(JobLogDTO::fromBody('FetchByDate - ' . $this->date->toDateString(), json_encode($neededPrices)));

        if (count($neededPrices) > 0) $priceService->upsert($neededPrices);
    }
}
