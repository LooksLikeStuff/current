<?php

namespace App\Http\Resources\Actives;

use App\Http\Services\DateService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActiveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'active' => $this->ticker->name,
            'company' => $this->ticker->company->name,
            'date' => DateService::getDefaultFormat($this->date),
            'quantity' => $this->quantity,
            'commission' => currency($this->commission),
            'price' =>  currency($this->price),
            'start_price' => currency($this->startPrice()),
            'closest_price' => currency($this->ticker->prices->first()->close ?? 0),
            'year_percent' => $this->yearPercent(),
            'is_profit_positive' => $this->isProfitPositive(),
            'profit' => currency($this->profit()),
        ];
    }
}
