<?php

namespace App\Exceptions;

use Illuminate\Support\Collection;

class InvalidMethod extends RenderableException
{
    public static function make(string $invalidMethodName, Collection $validMethodNames): self
    {
        $validMethodNames = $validMethodNames
            ->map(fn (string $method) => "`{$method}`")
            ->join(', ', ' and ');

        return new self("`{$invalidMethodName}` is not a valid method name. Valid method names are {$validMethodNames}.");
    }
}
