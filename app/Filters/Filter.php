<?php

namespace App\Filters;

use Illuminate\Http\Client\Response;

abstract class Filter
{
    abstract public function canFilter(Response $response, string $content): bool;

    abstract public function filter(Response $response, string $content, string $filter): string;
}
