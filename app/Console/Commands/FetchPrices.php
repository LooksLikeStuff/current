<?php

namespace App\Console\Commands;

use App\Http\Services\DateService;
use App\Jobs\Exchanges\MOEX\FetchPricesByDate;
use Illuminate\Console\Command;

class FetchPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prices:fetch
    {start : Start date of fetch period}
    {end? :  End date of fetch period.By default it is a current date}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch prices for every day in period';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $start = DateService::parse($this->argument('start'));
        $end = DateService::parse($this->argument('end'));


        do {
            dispatch(new FetchPricesByDate($start))->onQueue('default');

            $start->addDay();

        } while($start->diffInDays($end) != 0);

    }
}
