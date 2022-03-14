<?php

namespace App\Exceptions;

use Exception;

class InvalidPayload extends Exception
{
    public static function make(): self
    {
        return new self("You should pass valid JSON to the `payload option`");
    }
}
