<?php

namespace App\Filters;

use Illuminate\Testing\TestResponse;

class DummyFilter extends Filter
{
    public function canFilter(TestResponse $response, string $content): bool
    {
        return true;
    }

    public function filter(TestResponse $response, string $content, string $filter): string
    {
        return $content;
    }
}
