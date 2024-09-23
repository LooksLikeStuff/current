<?php

namespace App\Services;

use App\DTO\Tickers\FilterDTO;
use App\DTO\Tickers\TickerDTO;
use App\DTO\Actives\Api\Diagrams\FilterDTO as DiagramsFilterDTO;
use App\Http\Services\TransliterationService;
use App\Models\Active;
use App\Models\Ticker;
use App\Models\User;


class TickerService
{


    public function create(TickerDTO $tickerDTO)
    {
        return Ticker::create([
           'name' => $tickerDTO->name,
            'company_id' => $tickerDTO->companyId,
        ]);
    }

    public function getAll()
    {
        return Ticker::all();
    }

    public function find(TickerDTO $tickerDTO)
    {
        $subnames = TransliterationService::convertAll( explode(' ', $tickerDTO->name));

        //convert substrings for the LIKE operator
        $options = array_map(fn ($subname) =>  "%$subname%", $subnames);

        return Ticker::query()
            ->whereLike('name', $tickerDTO->name)
            ->orWhere('name', 'LIKE', TransliterationService::convertToEn($tickerDTO->name))

            ->orWhere(function ($q) use ($subnames, $options) {
                $q->where('name', 'LIKE', $subnames);
                foreach ($options as $subname) {
                    $q->orWhere('name', 'LIKE', $subname);
                }
            })

            ->orWhereHas('company', function ($q) use ($subnames, $options) {
                $q->where('name', 'LIKE', $subnames);
                foreach ($options as $subname) {
                    $q->orWhere('name', 'LIKE', $subname);
                }
            })

            ->orWhereHas('company', fn($q) => $q->whereLike('name', $tickerDTO->name))
            ->orWhereHas('company', fn($q) => $q->whereLike('name',TransliterationService::convertToRu($tickerDTO->name)))

            ->orWhereHas('tags', function ($q) use ($subnames, $options) {
                $q->where('title', 'LIKE', $subnames);
                foreach ($options as $subname) {
                    $q->orWhere('title', 'LIKE', $subname);
                }
            })
            ->with(['company', 'company.tags'])
            ->orderBy('name')
            ->get();


    }

    public function getById(int $tickerId)
    {
        return Ticker::find($tickerId);
    }

    public function updateOrCreate(TickerDTO $tickerDTO)
    {
        $uniqueBy = [
            'name' => $tickerDTO->name,
        ];

        return Ticker::updateOrCreate(
            $uniqueBy,
            [
                'name' => $tickerDTO->name,
                'company_id' => $tickerDTO->companyId,
            ]);
    }

    public function getUserActivesGroupByTickers(User $user, DiagramsFilterDTO $filterDTO)
    {
        $actives = $user->actives()
            ->where('date', '<=', $filterDTO->date)
            ->with(['ticker', 'prices' => fn($q) => $q->orderByDesc('date')->where('date', '<=', $filterDTO->date)])
            ->get();

        $actives->map(function (Active $active) {
            $active->close = $active->prices->first()->close ?? 0;

            return $active;
        });

        return $actives->groupBy(fn($active) => $active->ticker->name);
    }

    public function getUserPivotTickersData(User $user)
    {
        $tickers = $user->tickers()
            ->whereHas('actives', fn($query) => $query->where('user_id', $user->id))
            ->with([
                'actives' => fn($query) => $query->where('user_id', $user->id),
                'company',
            ])
            ->get();


        return $tickers;
    }

    public function getWithPricesByFilters(FilterDTO $filterDTO)
    {
        return Ticker::query()
            ->with([
                'prices' => fn($q) => $q->where('date', '<=', $filterDTO->date)->limit(Ticker::count()),
                'company'
            ])
            ->get()
            ->map(fn(Ticker $ticker) => $ticker->setRelation('price', $ticker->prices->first())->unsetRelation('prices'));
    }

}
