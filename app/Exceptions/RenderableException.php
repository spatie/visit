<?php

namespace App\Exceptions;

use App\Concerns\DisplaysMessages;
use Exception;

abstract class RenderableException extends Exception
{
    use DisplaysMessages;

    public function render()
    {
        $this->displayErrorMessage($this->message);
    }
}
