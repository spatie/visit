<?php

namespace App\Exceptions;

use Exception;

class TestException extends Exception
{
    public function render()
    {
        echo 'rendered';
    }
}
