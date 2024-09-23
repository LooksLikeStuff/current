<?php

namespace App\DTO\Tickers;

use App\Http\Requests\Tickers\FilterRequest;
use App\Http\Services\DateService;
use Carbon\Carbon;

readonly class FilterDTO
{
    public function __construct(
        public Carbon $date,
    )
    {
    }

    public static function fromFilterRequest(FilterRequest $request): self
    {
        return new self(
            date: DateService::parse($request->validated('date')),
        );
    }
}
