<?php

namespace App\Exceptions;

class NoUrlSpecified extends RenderableException
{
    public static function make(): self
    {
        return new self("You should either pass a URL as an argument or a valid route name to the `--route` option");
    }
}
