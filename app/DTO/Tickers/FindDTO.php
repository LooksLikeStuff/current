<?php

namespace App\DTO\Tickers;

use App\Http\Requests\Tickers\PriceRequest;
use App\Http\Services\DateService;
use App\Models\Ticker;
use App\Services\ActiveService;
use App\Services\TickerService;
use Carbon\Carbon;

readonly class FindDTO
{

    public function __construct(
        public Ticker $ticker,
        public Carbon $date,
    )
    {

    }


    public static function fromPriceRequest(PriceRequest $request): self
    {
        $ticker = (new TickerService())->getById($request->validated('ticker_id'));
        $date = DateService::parse($request->validated('date'));

        return new self(
            ticker: $ticker,
            date: $date,
        );
    }
}
