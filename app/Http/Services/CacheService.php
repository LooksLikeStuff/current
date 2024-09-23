<?php

namespace App\Http\Services;

use App\Models\User;

class CacheService
{
    public static function getKeyOfUserActivePricesForAllPeriod(User $user)
    {
        return $user->id  . '-'. 'actives';
    }
}
