<?php

namespace App\Stats;

class StatResult
{
    public string $name;

    public string $value = '';

    public static function make(string $name)
    {
        return new self($name);
    }

    protected function __construct(string $name)
    {
        $this->name = $name;
    }

    public function value(string $value): self
    {
        $this->value = $value;

        return $this;
    }
}
