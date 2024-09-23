<?php

namespace App\View\Composers;

use App\Services\TickerService;
use Illuminate\View\View;

class TickerComposer
{
    public function __construct(
        private readonly TickerService $service,
    )
    {
    }

    public function compose(View $view)
    {
        $tickers = $this->service->getAll();

        return $view->with(['tickers' => $tickers]);
    }
}
