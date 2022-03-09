<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;
use function Termwind\{render};

class VisitCommand extends Command
{
    protected $signature = 'visit';

    public function handle()
    {
        $this->info('here');
    }
}
