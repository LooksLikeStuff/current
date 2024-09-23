<?php

namespace App\DTO\Logs;

use App\Http\Services\DateService;
use Carbon\Carbon;

class JobLogDTO
{

    public function __construct(
        readonly string $name,
        readonly string $body,
        readonly Carbon $datetime,
    )
    {
    }

    public static function fromBody(string $jobName, string $body)
    {
        return new self(
            name: $jobName,
            body: $body,
            datetime: DateService::now(),
        );
    }
}
