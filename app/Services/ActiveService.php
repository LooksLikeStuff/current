<?php

namespace App\Services;

use App\DTO\Actives\ActiveDTO;
use App\DTO\Actives\FilterDTO;
use App\Enums\Period;
use App\Http\Services\DateService;
use App\Http\Services\TimeService;
use App\Models\Active;
use App\Models\Price;
use App\Models\Ticker;
use App\Models\User;
use Carbon\Carbon;

class ActiveService
{

    public function __construct(
        private readonly PriceService $priceService,
    )
    {
    }

    public function getUserActives()
    {
        return auth()->user()->actives()
            ->with(['ticker.closestPrices'])
            ->orderByDesc('date')
            ->get()
            ->sortBy(fn($active) => $active->ticker->name);
    }

    public function getUserTickerQuantity(User $user, Ticker $ticker)
    {
        return $user->actives()->where('ticker_id', $ticker->id)->sum('quantity');
    }

    public function store(ActiveDTO $activeDTO)
    {
        return Active::create([
            'user_id' => $activeDTO->userId,
            'ticker_id' => $activeDTO->tickerId,
            'date' => $activeDTO->date,
            'price' => $activeDTO->price,
            'quantity' => $activeDTO->quantity,
            'commission' => $activeDTO->commission,
        ]);
    }

    public function getUserActivesByFilters(FilterDTO $filterDTO)
    {
        $actives = auth()->user()->actives()
            ->with(['ticker.prices' => fn($q) => $q->orderByDesc('date')->where('date', '<=', $filterDTO->date)])
            ->where('date', '<=', $filterDTO->date)
            ->get();

        return $actives->sortBy(fn($active) => $active->ticker->name);
    }

    public function getUserActivesWithPrices(User $user)
    {
        $actives = $user->actives()
            ->orderBy('date')
            ->select(['id', 'ticker_id', 'date', 'quantity', 'commission', 'price'])
            ->get();

        $startDate = $actives->min(fn(Active $active) => $active->date)->subDays(15);
        $prices = $this->priceService->getByTickerIdsAndMinDate($startDate, $actives->pluck('ticker_id')->toArray());

        $actives->map(function (Active $active) use ($prices) {
            $active->setRelation('prices', $prices[$active->ticker_id]);

            return $active;
        });

        return $actives;
    }
    public function getUserActivesByPeriod(User $user, Period $period)
    {
        $actives = $user->actives()
            ->orderBy('date')
            ->select(['id', 'ticker_id', 'date', 'quantity', 'commission', 'price'])
            ->get();

        $startDate = DateService::now()->subDays($period->value + 2);
        $prices = $this->priceService->getByTickerIdsAndMinDate($startDate, $actives->pluck('ticker_id')->toArray());

        $actives->map(function (Active $active) use ($prices) {
            $active->setRelation('prices', $prices[$active->ticker_id]);

            return $active;
        });

        return $actives;
    }
}
