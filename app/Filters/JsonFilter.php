<?php

namespace App\Filters;

use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;

class JsonFilter extends Filter
{
    public function canFilter(TestResponse $response, string $content): bool
    {
        $contentType = $response->headers->get('content-type', '');

        if (! $contentType === 'application/json') {
            return false;
        }

        return (bool)json_decode($content, true);
    }

    public function filter(TestResponse $response, string $content, string $filter): string
    {
        $contentAsArray = json_decode($content, true);

        $filterContentAsArray = Arr::get($contentAsArray, $filter, []);

        return json_encode($filterContentAsArray);
    }
}
