<?php

namespace App\Stats;

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
