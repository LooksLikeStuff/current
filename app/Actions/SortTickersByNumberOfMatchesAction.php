<?php

namespace App\Actions;

use App\Http\Services\TransliterationService;
use App\Models\Active;
use App\Models\Price;
use App\Models\Ticker;
use Illuminate\Database\Eloquent\Collection;

class SortTickersByNumberOfMatchesAction
{
    public function handle(Collection $tickers, string $match)
    {
        $nameTickers = collect();
        $companyTickers = collect();
        $tagTickers = collect();
        $zeroesTickers = collect();

        foreach ($tickers as $ticker) {
            $namePos = mb_stripos($ticker->name, $match);
            $companyPos = mb_stripos($ticker->company->name ?? '', $match);

            if ($ticker->company && $ticker->company->tags) {
                $tagPos = mb_stripos(implode(' ', $ticker->company->tags->pluck('title')->toArray()) ?? '', $match);
            } else $tagPos = false;

            $sort = 0;
            if ($namePos !== false) {
                $nameTickers->push($ticker);
                $sort += $namePos;
            }

            elseif ($companyPos !== false)  {
                $companyTickers->push($ticker);
                $sort += $companyPos;
            }

            elseif ($tagPos !== false) {
                $tagTickers->push($ticker);
                $sort += $tagPos;

            } else {
                $zeroesTickers->push($ticker);
            }

            $ticker->sort = $sort;
        }

        $nameTickers = $nameTickers->sortBy(fn(Ticker $ticker) => $ticker->sort);
        $companyTickers = $companyTickers->sortBy(fn(Ticker $ticker) => $ticker->sort);
        $tagTickers = $tagTickers->sortBy(fn(Ticker $ticker) => $ticker->sort);

        return $nameTickers->merge($companyTickers)->merge($tagTickers)->merge($zeroesTickers);
    }
}
