<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Balance\CheckRequest;
use App\Http\Requests\Balance\UpRequest;

class BalanceController extends Controller
{
    public function up(UpRequest $request)
    {
        deposit($request->validated('sum'), 'RUB')->to(auth()->user())->overcharge()->commit();

        return response()->json(['success' => true]);
    }

}
