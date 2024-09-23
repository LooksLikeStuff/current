<?php

namespace App\Services;

use App\DTO\Logs\JobLogDTO;
use App\Models\JobLog;

class JobLogService
{
    public function create(JobLogDTO $dto)
    {
        return JobLog::create([
            'name' => $dto->name,
            'body' => $dto->body,
            'datetime' => $dto->datetime,
        ]);
    }
}
