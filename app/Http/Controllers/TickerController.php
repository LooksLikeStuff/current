<?php

namespace App\Http\Controllers;

use App\Actions\SortTickersByNumberOfMatchesAction;
use App\DTO\Tickers\FilterDTO;
use App\DTO\Tickers\FindDTO;
use App\DTO\Tickers\TickerDTO;
use App\Http\Requests\Tickers\FilterRequest;
use App\Http\Requests\Tickers\FindRequest;
use App\Http\Requests\Tickers\PriceRequest;
use App\Http\Resources\Prices\PriceResource;
use App\Http\Resources\Tickers\FindResource;
use App\Http\Services\DateService;
use App\Models\Active;
use App\Models\Ticker;
use App\Services\ActiveService;
use App\Services\PriceService;
use App\Services\TickerService;
use Illuminate\Http\Request;

class TickerController extends Controller
{
    public function __construct(
        private readonly TickerService $tickerService,
        private readonly PriceService $priceService,
        private readonly ActiveService $activeService,
    )
    {
    }

    public function find(FindRequest $request, SortTickersByNumberOfMatchesAction $action)
    {
        $tickers = $this->tickerService->find(TickerDTO::fromFindRequest($request));

        return FindResource::collection($action->handle($tickers, $request->validated('name')));
    }

    public function findForSell(FindRequest $request, SortTickersByNumberOfMatchesAction $action)
    {
        $tickers = $this->tickerService->find(TickerDTO::fromFindRequest($request));

        $userTickers = auth()->user()->tickers->pluck('id')->toArray();
        $tickers = $tickers->filter(fn(Ticker $ticker) => in_array($ticker->id, $userTickers));

        return FindResource::collection($action->handle($tickers, $request->validated('name')));
    }

    public function price(PriceRequest $request)
    {
        $dto = FindDTO::fromPriceRequest($request);
        $price = $this->priceService->getPriceByDate($dto->ticker, $dto->date);

        //fetch today price if price by date was not found
        if (!$price) $price = $this->priceService->getClosestPrice($dto->ticker, $dto->date);

        return (new PriceResource($price))->resolve();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        $dto = FilterDTO::fromFilterRequest($request);
        $tickers = $this->tickerService->getWithPricesByFilters($dto);

        return view('tickers.index', compact('tickers'))->with(['date' => DateService::getDefaultFormat($dto->date)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticker $ticker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticker $ticker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticker $ticker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticker $ticker)
    {
        //
    }

    public function pivot()
    {
        $tickers = $this->tickerService->getUserPivotTickersData(auth()->user());
        $fullPrice = $tickers->sum(function (Ticker $ticker) {
            $ticker->full_price = $ticker->actives->sum(function(Active $active) {
                return $active->closestPrice();
            });

            return $ticker->full_price;
        });

        return view('tickers.pivot', compact('tickers', 'fullPrice'));
    }
    
}
