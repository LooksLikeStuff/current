<?php

namespace App\Requests\Exchanges;

use App\DTO\Logs\JobLogDTO;
use App\Http\Services\DateService;
use App\Services\JobLogService;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class MOEX
{
    public function __construct(
        private readonly JobLogService $jobLogService,
    )
    {
    }

    private const TODAY_PRICES_URL = 'https://iss.moex.com/iss/engines/stock/markets/shares/boards/TQBR/securities.html?iss.meta=off&iss.only=marketdata&marketdata.columns=SECID,OPEN,HIGH,LOW,LAST';

    public function getPricesByDate(Carbon $day): array
    {
        $date = $day->toDateString();
        $prices = [];

        $url = "https://iss.moex.com/iss/history/engines/stock/markets/shares/boards/tqbr/securities.xml?date=$date";

        foreach ([0, 100, 200] as $start) {
            $xml = simplexml_load_string(file_get_contents($url . "&start=$start"));
            $json = json_encode($xml);
            $fetchedArray = json_decode($json,TRUE);

            //fetch only prices info and unpack it
            $prices = array_merge($prices, $fetchedArray['data'][0]['rows']['row'] ?? []);
        }


        //remove "@attributes" key
        foreach ($prices as $key => $price) $prices[$key] = $price[array_key_first($price)];

        return $prices;
    }

    public function getTodayPrices()
    {
        $todayDate = DateService::todayDate();

        $crawler = new Crawler(file_get_contents(self::TODAY_PRICES_URL));

        $table = $crawler->filter('table')->first();
        $priceRows = $table->children();

        $prices = [];
        foreach ($priceRows as $row) {
            $rowData = explode("\n", $row->textContent);

            $prices[] = [
                'ticker' => $rowData[1] && $rowData[1] != "null" ? $rowData[1] : null,
                'open' => $rowData[2] && $rowData[2] != "null" ? $rowData[2] : null,
                'high' => $rowData[3] && $rowData[3] != "null" ? $rowData[3] : null,
                'low' =>  $rowData[4] && $rowData[4] != "null" ? $rowData[4] : null,
                'close' =>  $rowData[5] && $rowData[5] != "null" ? $rowData[5] : null,
                'date' => $todayDate,
            ];
        }

        $this->jobLogService->create(JobLogDTO::fromBody('TodayPrices', json_encode($prices))); //log body

        return $prices;
    }
}
