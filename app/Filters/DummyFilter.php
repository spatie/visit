<?php

namespace App\Filters;

use Illuminate\Http\Client\Response;

class DummyFilter extends Filter
{
    public function canFilter(Response $response, string $content): bool
    {
        return true;
    }

    public function filter(Response $response, string $content, string $filter): string
    {
        return $content;
    }
}
