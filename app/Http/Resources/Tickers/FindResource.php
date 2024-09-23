<?php

namespace App\Http\Resources\Tickers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FindResource extends JsonResource
{
    public static $wrap = 'items';
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company' => $this->company,
        ];
    }
}
