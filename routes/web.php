<?php

use App\Http\Controllers\ActiveController;
use App\Http\Controllers\Api\ActiveController as ApiActiveController;
use App\Http\Controllers\Api\BalanceController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TickerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->to(route('login'));
})->middleware('guest');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //ActiveController
    Route::controller(ActiveController::class)->prefix('actives')->group(function () {
//        Route::get('pivot', 'pivot')->name('actives.pivot');
    });

    Route::resource('actives', ActiveController::class);
    Route::post('actives/sell', [ActiveController::class, 'sell'])->name('actives.sell');

    //PriceController
    Route::resource('prices', PriceController::class);

    //TickerController
    Route::controller(TickerController::class)->prefix('tickers')->group(function () {
        Route::get('pivot', 'pivot')->name('tickers.pivot');
        Route::get('price', 'price')->name('tickers.price');
        Route::post('find','find')->name('tickers.find');
        Route::post('find/sell','findForSell')->name('tickers.find.sell');
    });
    Route::resource('tickers', TickerController::class);

    Route::controller(BalanceController::class)->prefix('balance')->group(function () {
        Route::post('up', 'up')->name('balance.up');
    });
    Route::controller(TestController::class)->prefix('test')->group(function () {
       Route::get('date', 'getByDate')->name('test.date');
       Route::get('today', 'getToday')->name('test.today');
       Route::get('period', 'period')->name('test.period');
       Route::get('info', 'info')->name('test.info');
       Route::get('sectors', 'sectors')->name('test.sectors');
       Route::get('cache', 'cache')->name('test.cache');
    });



    Route::controller(ApiActiveController::class)->prefix('api/actives')->group(function () {
        Route::post('/tickers', 'tickers')->name('api.actives.tickers');
        Route::post('/sectors', 'sectors')->name('api.actives.sectors');
        Route::post('/period', 'period')->name('api.actives.period');
        Route::post('/period/month', 'month')->name('api.actives.period.month');
        Route::post('/{ticker}/quantity', 'quantity')->name('api.ticker.quantity');
    });


    //Language Translation
    Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
    Route::view('instructions', 'instructions.main')->name('instructions');

//    Route::get('/dividends', function () {
//       $job = new \App\Jobs\ParseDividendsJob();
//       $job->handle(new \Symfony\Component\DomCrawler\Crawler());
//    });
});



require __DIR__.'/auth.php';
