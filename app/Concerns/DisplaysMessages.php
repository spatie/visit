<?php

namespace App\Concerns;

use function Termwind\render;

trait DisplaysMessages
{
    public function displayErrorMessage(string $messages): self
    {
        $this->displayMessage($messages, 'bg-red text-white');

        return $this;
    }

    public function displayMessage(string $message, string $headerStyle = 'bg-green text-black'): self
    {
        $messageView = view('message', [
            'headerStyle' => $headerStyle,
            'message' => $message,
        ]);

        render($messageView);

        return $this;
    }
}
