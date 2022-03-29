<?php

namespace App\Exceptions;

class CouldNotMakeRequest extends RenderableException
{
    public static function make(string $message): self
    {
        return new self($message);
    }
}
