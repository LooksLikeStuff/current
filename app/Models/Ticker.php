<?php

namespace App\Models;

use App\Http\Services\DateService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeSorted(Builder $query)
    {
        $query->orderBy('name', 'desc');
    }

    public function prices()
    {
        return $this->hasMany(Price::class)->orderByDesc('date');
    }

    public function price()
    {
        return $this->hasOne(Price::class)->orderByDesc('date');
    }

    public function closestPrices()
    {
        return $this->prices()->orderByDesc('date')->limit(10);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function todayPrice()
    {
        return $this->closestPrices
            ->where('date', DateService::todayDate())
            ->first();
    }

    public function closestPrice(string $date = null)
    {
        if ($date) {
            $date = DateService::parse($date)->addDay()->startOfDay();

            return $this->prices->firstWhere('date', '<=', $date);
        }

        return $this->closestPrices->first();
    }

    public function actives()
    {
        return $this->hasMany(Active::class);
    }

    public function profit($date = null)
    {
        $tickerPrice = 0;
        foreach ($this->actives as $active) {
            $closestPrice = $active->ticker->closestPrice($date);

            $price = 0;
            if ($closestPrice) $price = $closestPrice->close * $active->quantity - $active->getRawOriginal('commission');

            $tickerPrice += $price - $active->startPrice();
        }

        return $tickerPrice;
    }

    public function tags()
    {
        return $this->hasManyThrough(
            Tag::class,
            Company::class,
            'id',
            'company_id',
            'company_id',
            'id',
        );
    }

}
