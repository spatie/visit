<?php

namespace App\Exceptions;

use Exception;

class NoUrlSpecified extends Exception
{
    public static function make(): self
    {
        return new self("You should either pass a URL as an argument or a valid route name to the `--route` option");
    }
}
