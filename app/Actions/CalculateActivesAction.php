<?php

namespace App\Actions;

use App\Enums\Period;
use App\Http\Services\DateService;
use App\Http\Services\TimeService;
use App\Models\Active;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Ramsey\Uuid\Type\Time;

class CalculateActivesAction
{
    public $activeIds = [];
    public $dates = [];
    public $actives;
    public $sums = [];
    public $sumsWithoutPurchases = [];
    public $percents = [];
    public $startSums = [];
    public $indexedActives = [];


    public function countSum($dateStr) {
        $sum = 0;
        $sumWithoutPurchases = 0;

        foreach ($this->actives as $active) {
            if (!$active->last_price) $active->last_price = 0;

            $activeDate = $active->getOriginalDate();

            if ($activeDate < $dateStr) {
                $activePrice = array_key_exists($dateStr, $active->prices) ? $active->prices[$dateStr] : $active->last_price;
                $active->last_price = $activePrice;
                $activeLastPrice = $active->quantity * $active->last_price;

                $sum += $activeLastPrice;

                if (in_array($active->id, $this->activeIds)) $sumWithoutPurchases += $activeLastPrice;
            }

            elseif ($activeDate == $dateStr) $sum += $active->startPrice();
        }

        $this->sumsWithoutPurchases[$dateStr] = $sumWithoutPurchases;
        $sum = round($sum, 2);

        return $sum;
    }

    public function countStartSum($dateStr, float $percent) {
        $sum = 0;
        foreach ($this->actives as $active) {
            if (($active->getOriginalDate() <= $dateStr) && (!in_array($active->id, $this->activeIds))) {
                $sum += $active->startPrice();
                $this->activeIds[] = $active->id;
            }
        }

        if ($percent == 0) { $percent = 100; }
        return $sum * 100 / $percent;
    }

    public function getFirstDate() {
        return $this->actives->min(fn(Active $active) => $active->getOriginalDate());
    }

    public function setDates($firstDateStr) {

        foreach ($this->actives as $active) {
            foreach ($active->prices as $date => $value) {
                if ($firstDateStr <= $date) {
                    $this->dates[$date] = $date;
                }
            }
        }
        asort($this->dates);
    }

    public static function pround($sum) {
        return round($sum * 100, 2);
    }

    public function handle(Collection $actives) {
        $this->actives = $actives;
        $firstDate = $this->getFirstDate();

        $this->actives->each(function (Active $active) use ($firstDate) {
            if ($active->getOriginalDate() == $firstDate)  $this->activeIds[] = $active->id;
        });

        $this->setDates($firstDate);

        $prevDate = '';
        foreach ($this->dates as $date) {
            $sum = $this->countSum($date);

            if ($sum == 0) { //нулевые котировки в дне - 21 марта 2022
                continue;
            }
            $this->sums[$date] = $sum;

            if ($prevDate == '') {
                $this->startSums[$date] = $this->sums[$date];
                $this->percents[$date] = 100;
            } else {
                $prevStartSum = $this->startSums[$prevDate];

                $this->percents[$date] = self::pround($this->sumsWithoutPurchases[$date] / $prevStartSum);
                $this->startSums[$date] = $prevStartSum + $this->countStartSum($date, $this->percents[$date]);
            }

            $prevDate = $date;

            if (isset($this->sums[$date])) {
                $dateTimestampMs = strtotime($date) * 1000;
                $this->indexedActives[$dateTimestampMs] = [
                    'mdates' => $date,
                    'values' => $this->sums[$date],
                    'percent' => $this->percents[$date],
                    'startSum' => $this->startSums[$date]
                ];
            }
        }

        return $this->indexedActives;
    }
}

