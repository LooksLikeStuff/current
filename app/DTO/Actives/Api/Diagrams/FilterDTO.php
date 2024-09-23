<?php

namespace App\DTO\Actives\Api\Diagrams;

use App\Http\Requests\Actives\Api\Diagrams\FilterRequest;
use App\Http\Services\DateService;
use Carbon\Carbon;

readonly class FilterDTO
{
    public Carbon $date;
    public function __construct(
        ?string $date = null,
    )
    {
        $this->date = DateService::parse($date);
    }

    public static function fromFilterRequest(FilterRequest $request): self
    {
        return new self(date: $request->validated('date'));
    }
}
