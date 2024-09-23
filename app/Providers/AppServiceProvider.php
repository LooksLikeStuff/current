<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        //add whereLike method to eloquent
        Builder::macro('whereLike', function($column, $search) {
            return $this->where($column, 'LIKE', "%{$search}%");
        });

        //add orWhereLike method to eloquent
        Builder::macro('orWhereLike', function($column, $search) {
            return $this->orWhere($column, 'LIKE', "%{$search}%");
        });
    }
}
