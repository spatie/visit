<?php

use Tests\Support\ArtisanOutput;
use Tests\Support\TestCase;

uses(TestCase::class)->in(__DIR__);

function expectOutputContains(string ...$substrings)
{
    $output = ArtisanOutput::get();

    collect($substrings)->each(fn (string $substring) => expect($output)->toContain($substring));
}

function expectOutputDoesNotContain(string ...$substrings)
{
    $output = ArtisanOutput::get();

    collect($substrings)->each(fn (string $substring) => expect($output)->not()->toContain($substring));
}
