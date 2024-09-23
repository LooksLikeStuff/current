<?php

namespace App\Services;

use App\Http\Services\DateService;
use App\Http\Services\TimeService;
use App\Models\Price;
use App\Models\Ticker;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PriceService
{

//    public function upsert(array|Collection $prices): true
//    {
//        if (is_array($prices)) $prices = collect($prices);
//
//        foreach ($prices->chunk(100) as $chunk) {
//            Price::upsert($chunk->toArray(), ['ticker_id'], ['open', 'close']);
//        }
//
//        return true;
//    }

    public function upsert(array|Collection $prices): true
    {
        if ($prices instanceof Collection) $prices = $prices->toArray();

        foreach ($prices as $price) {
            if (! isset($price['ticker_id'])) continue;

            $uniqueBy = [
                'ticker_id' => $price['ticker_id'],
                'date' => $price['date'],
            ];

            Price::updateOrCreate($uniqueBy, $price);
        }

        return true;
    }

    public function getAll()
    {
        return Price::all();
    }

    public function getPriceByDate(Ticker $ticker, Carbon $date)
    {
        return $ticker->prices()
            ->where('date', $date->toDateString())
            ->first();

    }

    public function getClosestPrice(Ticker $ticker, Carbon $date)
    {
        return $ticker->prices()
            ->where('date', '<', $date->toDateString())
            ->orderByDesc('date')
            ->first();
    }

    public function getTodayPrice(Ticker $ticker)
    {
        return $ticker->prices()
            ->where('date', DateService::todayDate())
            ->first();
    }

    public function getByTickerIdsAndMinDate(Carbon $date, array $tickerIds)
    {
        $prices = Price::select(['date', 'close', 'ticker_id'])
            ->whereIn('ticker_id', $tickerIds)
            ->orderBy('date')
            ->where('date', ">=", $date)
            ->getQuery()
            ->get();


        return $prices->reduce(function ($carry, $price) {
            $carry[$price->ticker_id][$price->date] = $price->close;

            return $carry;
        }, []);

    }
}
