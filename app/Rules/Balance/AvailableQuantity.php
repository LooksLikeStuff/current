<?php

namespace App\Rules\Balance;

use AllowDynamicProperties;
use App\Models\Ticker;
use App\Services\ActiveService;
use App\Services\PriceService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

#[AllowDynamicProperties] class AvailableQuantity implements ValidationRule
{

    public function __construct(?int $tickerId)
    {
        $this->tickerId = $tickerId;
        $this->activeService = new ActiveService(new PriceService());
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->tickerId)) $fail('Необходимо выбрать тикер');

        $availableQuantity = auth()->user()->actives()->where('ticker_id', $this->tickerId)->sum('quantity');
        if ($value > $availableQuantity) $fail('Максимальное количество - ' . $availableQuantity . '.');
    }
}
