<?php

namespace App\Http\Controllers\Api;

use App\Actions\CalculateActivesAction;
use App\Actions\PrepareApiActivesAction;
use App\DTO\Actives\Api\Diagrams\FilterDTO;
use App\Enums\Period;
use App\Http\Controllers\Controller;
use App\Http\Requests\Actives\Api\Diagrams\FilterRequest;
use App\Http\Requests\Actives\Api\PeriodRequest;
use App\Http\Resources\Actives\Api\SectorResource;
use App\Http\Resources\Actives\Api\TickerResource;
use App\Http\Services\CacheService;
use App\Http\Services\DateService;
use App\Models\Ticker;
use App\Services\ActiveService;
use App\Services\SectorService;
use App\Services\TickerService;
use Illuminate\Support\Facades\Cache;


class ActiveController extends Controller
{
    public function __construct(
        private readonly ActiveService           $activeService,
        private readonly TickerService           $tickerService,
        private readonly SectorService           $sectorService,
        private readonly PrepareApiActivesAction $prepareApiActivesAction,
        private readonly CalculateActivesAction  $calculateActivesAction,
    )
    {
    }

    public function tickers(FilterRequest $request)
    {
        $dto = FilterDTO::fromFilterRequest($request);
        $groupedActives = $this->tickerService->getUserActivesGroupByTickers(auth()->user(), $dto);

        return TickerResource::collection($this->prepareApiActivesAction->handle($groupedActives, $dto));
    }

    public function sectors(FilterRequest $request)
    {
        $dto = FilterDTO::fromFilterRequest($request);
        $groupedActives = $this->sectorService->getUserActivesGroupBySector(auth()->user(), $dto);

        return SectorResource::collection($this->prepareApiActivesAction->handle($groupedActives, $dto));
    }

    public function period(PeriodRequest $request)
    {
        $user = auth()->user();
        $periods = json_decode($request->validated('periods'));

        $key = CacheService::getKeyOfUserActivePricesForAllPeriod($user);
        if (Cache::has($key)) $all = Cache::get($key);
        else {
            $actives = $this->activeService->getUserActivesWithPrices($user);
            //get prices for every day from the first active date to now
            $all = $this->calculateActivesAction->handle($actives);
            Cache::put($key, $all);
        }

        $values = [];
        $percent = [];
        foreach ($all as  $item) {
            $values[] = $item['values'];
            $percent[] = $item['percent'];
        }

        $dates =  array_keys($all);
        $purchases = $user->actives()->pluck('date')->map(fn(string $date) => DateService::parse($date)->addHours(3)->startOfDay()->getTimestampMs())->toArray();
        $data = [
            //get user active dates and convert them to timestampMs
            'purchases' => $purchases,
            'all' => [
                1 => [
                    'actives' => [
                        'dates' => $dates,
                        'values' => $values,
                        'percent' => $percent,
                    ]
                ]
            ]
        ];

        foreach ($periods as $item) {
            $periodName = mb_strtoupper($item->period);
            $period = Period::{$periodName};
            if ($period->name === Period::ALL->name) continue;

            $copy = $all;

            $values = [];
            $percent = [];

            $periodLength = $period->value * $item->amount;
            $datePeriodStart = (strtotime("-" . $periodLength . "days") - 3 * 60 * 60) * 1000;

            $pricesForPeriod = [];
            foreach ($copy as $key => $arr) {
                if ($key >= $datePeriodStart) {
                    $pricesForPeriod[$key] = $arr;
                }
            }

            //$pricesForPeriod = array_slice($copy, round(-$periodLength), $periodLength, true);

            $dates = array_keys($pricesForPeriod);

            //YTD
            if ($periodName == Period::DAY->name) {
                $startOfTheYear = (strtotime(date("Y-01-01")) - 3 * 60 * 60) * 1000;
                $pricesForPeriod = [];
                foreach ($copy as $key => $arr) {
                    if ($key >= $startOfTheYear) {
                        $pricesForPeriod[$key] = $arr;
                    }
                }

            }

            $percents = array_values($pricesForPeriod)[0]['percent'];
            foreach ($pricesForPeriod as $info) {
                $values[] = $info['values'];
                $percent[] = round($info['percent'] / $percents * 100, 2);
            }

            $data[$item->period][$item->amount] = [
                'actives' => [
                    'dates' => $dates,
                    'values' => $values,
                    'percent' => $percent,
                ],
            ];
        }

        return response()->json($data);
    }

    public function month()
    {
        $user = auth()->user();
        $period = Period::MONTH;

        $actives = $this->activeService->getUserActivesByPeriod($user, $period);
        //get prices for every day from the first active date to now
        $prices = $this->calculateActivesAction->handle($actives);

        $values = [];
        $percent = [];
        foreach ($prices as  $item) {
            $values[] = $item['values'];
            $percent[] = $item['percent'];
        }

        $purchases = $user->actives()->pluck('date')->map(fn(string $date) => DateService::parse($date)->addHours(3)->startOfDay()->getTimestampMs())->toArray();
        $data = ['purchases' => $purchases,];

        $values = [];
        $percent = [];

        $datePeriodStart = (strtotime("-" . $period->value . "days") - 3 * 60 * 60) * 1000;

        $pricesForPeriod = [];
        foreach ($prices as $key => $arr) {
            if ($key >= $datePeriodStart) {
                $pricesForPeriod[$key] = $arr;
            }
        }

        $dates = array_keys($pricesForPeriod);

        $percents = array_values($pricesForPeriod)[0]['percent'];
        foreach ($pricesForPeriod as $info) {
            $values[] = $info['values'];
            $percent[] = round($info['percent'] / $percents * 100, 2);
        }

        $data['month'][1] = [
            'actives' => [
                'dates' => $dates,
                'values' => $values,
                'percent' => $percent,
            ],
        ];

        return response()->json($data);
    }

    /**
     * get available quantity for sale
     * @param Ticker $ticker
     * @return \Illuminate\Http\JsonResponse
     */
    public function quantity(Ticker $ticker)
    {
        $quantity = $this->activeService->getUserTickerQuantity(auth()->user(), $ticker);

        return response()->json(['quantity' => $quantity]);
    }
}
