<?php

namespace App\Models;

use App\Http\Services\DateService;
use Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticker_id',
        'close',
        'open',
        'high',
        'low',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => DateService::parse($value),
        );
    }
}
