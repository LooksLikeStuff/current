<?php

namespace App\Jobs;

use App\Models\Ticker;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Page;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\DomCrawler\Crawler;

class ParseDividendsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const URL = 'https://investmint.ru/';
    /**
     * Create a new job instance.
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $ticker = Ticker::select('name')->first();
//        foreach ($tickers as $ticker) {
        $html = file_get_contents('https://beststocks.ru/rustock/' . mb_strtolower($ticker->name) . '/dividends');

            if ($html) {
                $crawler = new Crawler($html);
                $component = $crawler->filter('tbody')->first();

                dd($component);

                foreach ($components as $value) {
                    dd($value->nodeName);
                }
            }
//        }
    }
}
