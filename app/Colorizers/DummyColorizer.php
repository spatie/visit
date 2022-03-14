<?php

namespace App\Colorizers;

class DummyColorizer extends Colorizer
{
    public function colorize(string $content): string
    {
        return $content;
    }
}
