<?php

namespace App\Http\Controllers;

use App\Actions\CalculateActivesAction;
use App\Actions\CalculateForPivotDataAction;
use App\DTO\Actives\ActiveDTO;
use App\DTO\Actives\FilterDTO;
use App\Http\Requests\Actives\CreateRequest;
use App\Http\Requests\Actives\FilterRequest;
use App\Http\Requests\Actives\SellRequest;
use App\Http\Resources\Actives\ActiveResource;
use App\Models\Active;
use App\Services\ActiveService;
use App\Services\TickerService;
use Illuminate\Http\Request;

class ActiveController extends Controller
{
    public function __construct(
        private readonly ActiveService $service,

    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(FilterRequest $request)
    {
        if ($request->ajax()) {
            $actives = $this->service->getUserActivesByFilters(FilterDTO::fromFilterRequest($request));

            return view('actives.components.content', compact('actives'))->with('date', $request->validated('date'));
        }
        else {
            $actives = $this->service->getUserActives();
            return view('index', compact('actives'));
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        $active = $this->service->store(ActiveDTO::fromCreateRequest($request));
        charge($active->startPrice(), 'RUB')->from($active->user)->commit();

        return back()->with('active', $active);
    }

    /**
     * Display the specified resource.
     */
    public function show(Active $active)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Active $active)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Active $active)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Active $active)
    {
        $sum = $active->closestPrice();
        deposit($sum, 'RUB')->to($active->user)->overcharge()->commit();

        $active->delete();

        return back();
    }

    public function sell(SellRequest $request)
    {
        $active = $this->service->store(ActiveDTO::fromSellRequest($request));
        deposit(abs($active->startPrice()), 'RUB')->to($active->user)->overcharge()->commit();

        return back()->with('active', $active);
    }

}
