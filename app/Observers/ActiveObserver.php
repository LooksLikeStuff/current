<?php

namespace App\Observers;

use App\Http\Services\CacheService;
use App\Models\Active;

class ActiveObserver
{
    /**
     * Handle the Active "created" event.
     */
    public function created(Active $active): void
    {
        \Cache::forget(CacheService::getKeyOfUserActivePricesForAllPeriod($active->user));
    }

    /**
     * Handle the Active "updated" event.
     */
    public function updated(Active $active): void
    {
        \Cache::forget(CacheService::getKeyOfUserActivePricesForAllPeriod($active->user));
    }

    /**
     * Handle the Active "deleted" event.
     */
    public function deleted(Active $active): void
    {
        \Cache::forget(CacheService::getKeyOfUserActivePricesForAllPeriod($active->user));
    }

    /**
     * Handle the Active "restored" event.
     */
    public function restored(Active $active): void
    {
        \Cache::forget(CacheService::getKeyOfUserActivePricesForAllPeriod($active->user));
    }

    /**
     * Handle the Active "force deleted" event.
     */
    public function forceDeleted(Active $active): void
    {
        //
    }
}
