<?php

namespace App\Stats;

use Illuminate\Contracts\Foundation\Application;

abstract class Stat
{
    public function beforeRequest(Application $app)
    {
    }

    public function afterRequest(Application $app)
    {
    }

    abstract public function getStatResult(): StatResult;
}
