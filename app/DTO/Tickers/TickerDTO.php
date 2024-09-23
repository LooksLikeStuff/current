<?php

namespace App\DTO\Tickers;
use App\Http\Requests\Tickers\FindRequest;
use App\Http\Requests\Tickers\PriceRequest;
use App\Models\Ticker;
use Carbon\Carbon;
use Illuminate\Support\Collection;

readonly class TickerDTO
{
    public function __construct(
        public string $name,
        public ?int $companyId = null,
    )
    {
    }

    public static function fromName(string $name): self
    {
        return new self($name);
    }


    public static function fromFindRequest(FindRequest $request): self
    {
        return new self(
            name:  $request->validated('name'),
        );
    }

    public static function fromCollectionOrArray(Collection|array $options): self
    {
        if ($options instanceof Collection) $options = $options->toArray();

        return new  self(
            name: $options['name'],
            companyId: $options['company_id'],
        );
    }


}
