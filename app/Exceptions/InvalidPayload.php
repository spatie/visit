<?php

namespace App\Exceptions;

use Exception;

class InvalidPayload extends RenderableException
{
    public static function make(): self
    {
        return new self("You should pass valid JSON to the `payload option`");
    }
}
