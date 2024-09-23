<?php

namespace App\Http\Controllers;

use App\Actions\CalculateActivesAction;
use App\Actions\PrepareApiActivesAction;
use App\Enums\Period;
use App\Http\Requests\TestRequest;
use App\Http\Resources\Actives\Api\SectorResource;
use App\Http\Services\CacheService;
use App\Http\Services\DateService;
use App\Http\Services\TimeService;
use App\Jobs\Exchanges\MOEX\FetchPricesByDate;
use App\Services\ActiveService;
use App\Services\SectorService;
use App\Http\Requests\Actives\Api\Diagrams\FilterRequest;
use App\DTO\Actives\Api\Diagrams\FilterDTO;
use Illuminate\Support\Facades\Cache;

class TestController extends Controller
{
    public function __construct(
        private readonly ActiveService $activeService,
        private readonly SectorService $sectorService,
        private readonly PrepareApiActivesAction $prepareApiActivesAction,
        private readonly CalculateActivesAction $calculateActivesAction,
    )
    {
    }

    public function getByDate(TestRequest $request)
    {
        $date = DateService::parse($request->validated('date'));
        dispatch(new FetchPricesByDate($date));

        return back();
    }

    public function getToday()
    {
        $job = new \App\Jobs\Exchanges\MOEX\FetchTodayPrices();
        $job->handle(new \App\Requests\Exchanges\MOEX, new \App\Services\TickerService(new ActiveService()), new \App\Services\PriceService());

        return back();
    }

    public function info()
    {
        phpinfo();
    }
    public function period()
    {
        $user = auth()->user();
        $actives = $this->activeService->getUserActivesWithPrices($user);

        $all = $this->calculateActivesAction->handle($actives, Period::ALL);
        dd($all);
        $data = [
            'all' => [
                1 => [
                    'actives' => [
                        'dates' => array_keys($all),
                        'values' => array_values($all),
                    ]
                ]
            ]
        ];

        dd($data);
        foreach (Period::cases() as $period) {
            if ($period->name == Period::DAY->name || $period->name == Period::ALL->name) continue;
            $copy = $all;

            $pricesForPeriod = array_slice($copy, -$period->value, $period->value, true);
            $data[mb_strtolower($period->name)][1] = [
                'actives' => [
                    'dates' => array_keys($pricesForPeriod),
                    'values' => array_values($pricesForPeriod),
                ],
            ];
        }


        dd($data);
//
//        $key = CacheService::getUserActivesForPeriodsCacheKey($user);
//        Cache::delete($key);
//
//        if (Cache::has($key)) $data = Cache::get($key);
//        else {
//
//            $data = $this->calculateActivesAction->handle($actives, Period::MONTH);
//
//            Cache::put($key, $data, now()->addMinutes(10));
//        }


//        dd($data);
//     return view('instructions.main', compact('data'));
    }

    public function sectors(FilterRequest $request)
    {


        $dto = FilterDTO::fromFilterRequest($request);
        $groupedActives = $this->sectorService->getUserActivesGroupBySector(auth()->user(), $dto);

        $time = new TimeService();
        $actives = $this->prepareApiActivesAction->handle($groupedActives, $dto);
        dd($time->diff());
        return SectorResource::collection();
    }

    public function cache()
    {
        $key = CacheService::getKeyOfUserActivePricesForAllPeriod(auth()->user());

        if (Cache::has($key)) $cache = Cache::get($key);
        else return redirect()->to(route('actives.index'));

        return view('test.cache', compact('cache'));
    }
}
