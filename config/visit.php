<?php

return [
    /*
     * These classes are responsible for colorizing the output.
     */
    'colorizers' => [
        App\Colorizers\JsonColorizer::class,
        App\Colorizers\HtmlColorizer::class,
    ],

    /*
     * There classes can filter the content of a response.
     */
    'filters' => [
        App\Filters\JsonFilter::class,
        App\Filters\HtmlFilter::class,
    ],

    /*
     * These stats will be displayed in the response block.
     */
    'stats' => [
        App\Stats\RuntimeStat::class,
    ],
];
