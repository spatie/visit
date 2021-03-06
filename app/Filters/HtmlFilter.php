<?php

namespace App\Filters;

use Illuminate\Http\Client\Response;
use Symfony\Component\DomCrawler\Crawler;

class HtmlFilter extends Filter
{
    public function canFilter(Response $response, string $content): bool
    {
        $contentType = $response->header('content-type');

        return str_contains($contentType, 'html');
    }

    public function filter(Response $response, string $content, string $filter): string
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
