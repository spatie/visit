<?php

namespace App\Filters;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

class JsonFilter extends Filter
{
    public function canFilter(Response $response, string $content): bool
    {
        $contentType = $response->header('content-type');

        if (! $contentType === 'application/json') {
            return false;
        }

        return (bool)json_decode($content, true);
    }

    public function filter(Response $response, string $content, string $filter): string
    {
        $contentAsArray = json_decode($content, true);

        $filterContentAsArray = Arr::get($contentAsArray, $filter, []);

        return json_encode($filterContentAsArray);
    }
}
