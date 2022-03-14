<?php

namespace App\Filters;

use Illuminate\Testing\TestResponse;
use Symfony\Component\DomCrawler\Crawler;

class HtmlFilter extends Filter
{
    public function canFilter(TestResponse $response, string $content): bool
    {
        $contentType = $response->headers->get('content-type', '');

        return str_contains($contentType, 'html');
    }

    public function filter(TestResponse $response, string $content, string $filter): string
    {
        $filteredHtml = '';

        $crawler = new Crawler($content);

        $crawler
            ->filter($filter)
            ->each(function (Crawler $node) use (&$filteredHtml) {
                return $filteredHtml .= $node->outerHtml();
            });

        return $filteredHtml;
    }
}
