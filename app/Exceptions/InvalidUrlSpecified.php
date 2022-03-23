<?php

namespace App\Exceptions;

class InvalidUrlSpecified extends RenderableException
{
    public static function make(): self
    {
        return new self("You should pass a valid URL.");
    }
}
