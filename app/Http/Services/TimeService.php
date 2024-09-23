<?php

namespace App\Http\Services;

class TimeService
{
    public $start;
    public $step;
    public function __construct()
    {
        $this->start = microtime(true);
    }

    public function diff()
    {
        $this->step = microtime( true);

        $diff = sprintf( '%.6f sec.', $this->step - $this->start);

        return $diff;
    }

    public function end()
    {
        return (microtime(true) - $this->start);
    }
}
