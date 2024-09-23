<?php

namespace App\DTO\Actives;

use App\Http\Requests\Actives\CreateRequest;
use App\Http\Requests\Actives\SellRequest;
use App\Http\Services\DateService;
use App\Models\Ticker;

readonly class ActiveDTO
{
    public function __construct(
        public int    $userId,
        public int    $tickerId,
        public string $date,
        public float  $quantity,
        public float  $price,
        public float  $commission,
    )
    {
    }

    public static function fromCreateRequest(CreateRequest $request): self
    {
        return new self(
            userId: auth()->id(),
            tickerId: $request->validated('ticker_id'),
            date: $request->validated('date'),
            quantity: $request->validated('quantity'),
            price: $request->validated('price'),
            commission: $request->validated('commission'),
        );
    }

    public static function fromSellRequest(SellRequest $request): self
    {
        $ticker = Ticker::find($request->validated('ticker_id'));
        return new self(
            userId: auth()->id(),
            tickerId: $ticker->id,
            date: DateService::todayDate(),
            quantity: -$request->validated('quantity'),
            price: $ticker->closestPrice()->close,
            commission: 0,
        );
    }
}
