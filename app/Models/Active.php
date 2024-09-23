<?php

namespace App\Models;

use App\Http\Services\DateService;
use App\Http\Services\NumberService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Active extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticker_id',
        'date',
        'price',
        'quantity',
        'commission',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function prices()
    {
        return $this->hasManyThrough(
            Price::class,
            Ticker::class,
            'id',
            'ticker_id',
            'ticker_id',
            'id',
        );
    }

    public function ownedForYear($time = null)
    {
        $start = !is_null($time) ? DateService::parse($time) : DateService::now();

        return $start->diffInYears(DateService::parse($this->date), false) < 0;
    }

    public function ticker()
    {
        return $this->belongsTo(Ticker::class);
    }

    public function startPrice()
    {
        return $this->price * $this->quantity - $this->getRawOriginal('commission');
    }

    public function profit(string $date = null)
    {
        $closestPrice = $this->ticker->closestPrice($date);

        $price = 0;
        if ($closestPrice) $price = $closestPrice->close * $this->quantity - $this->getRawOriginal('commission');

        return $price - $this->startPrice();
    }

    public function isProfitPositive(string $date = null): bool
    {
        return $this->profit($date) >= 0.00001;
    }

    protected function date()
    {
        return Attribute::make(
            get: fn(string $value) => DateService::parse($value),
        );
    }

    public function todayPrice()
    {
        $price = $this->ticker->todayPrice();
        if (!$price) $price = $this->ticker->closestPrice();

        return $price ? $price->close * $this->quantity : 0;
    }

    public function closestPrice(string $date = null)
    {
        $closestPrice = $this->ticker->closestPrice($date);

        if ($closestPrice) $close = $closestPrice->close;
        else $close = 0;

        return $close * $this->quantity;
    }

    public function calculatePrice(float $close)
    {
        return $close * $this->quantity;
    }
    public function yearPercent(string $date = null)
    {
        $part = $this->closestPrice($date) /  $this->startPrice();

        $closestDate =  $date ? DateService::parse($date) : DateService::now();
        $diffInDays = $closestDate->diffInDays(DateService::parse($this->date));

        if ($diffInDays == 0) $deg = 0;
        else $deg = 365.25 / $diffInDays;

        $p = $part ** $deg;

        return round(($p - 1) * 100, 2);
    }

    public function currentPercent(string $date = null)
    {
        $part = $this->closestPrice($date) / $this->startPrice();

        return round($part * 100 - 100, 2);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOriginalDate()
    {
        return $this->getRawOriginal('date');
    }
}
