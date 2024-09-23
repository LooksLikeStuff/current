<?php

namespace App\Providers;

use App\View\Composers\UserComposer;
use App\View\Composers\TickerComposer;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        view()->composer(['actives.index'], TickerComposer::class);
        view()->composer(['actives.components.content', 'layouts.main'], UserComposer::class);
    }
}
