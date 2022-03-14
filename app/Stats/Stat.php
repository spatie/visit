<?php

namespace App\Stats;

use Illuminate\Contracts\Foundation\Application;

abstract class Stat
{
    public function beforeRequest()
    {
    }

    public function afterRequest()
    {
    }

    abstract public function getStatResult(): StatResult;
}
