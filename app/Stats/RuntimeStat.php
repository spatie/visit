<?php

namespace App\Stats;

use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Stopwatch\StopwatchEvent;

class RuntimeStat extends Stat
{
    protected Stopwatch $stopwatch;

    protected ?StopwatchEvent $stopwatchEvent = null;

    public function __construct()
    {
        $this->stopwatch = new Stopwatch(true);
    }

    public function beforeRequest(Application $app)
    {
        $this->stopwatch->start('default');
    }

    public function afterRequest(Application $app)
    {
        $this->stopwatchEvent = $this->stopwatch->stop('default');
    }

    public function getStatResult(): StatResult
    {
        $duration = $this->stopwatchEvent->getDuration();

        return StatResult::make('Duration')
            ->value($duration . 'ms');
    }
}
