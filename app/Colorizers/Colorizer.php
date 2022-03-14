<?php

namespace App\Colorizers;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

abstract class Colorizer
{
    public function canColorize(string $contentType): bool
    {
        if ($this->getColorizerToolName() === '') {
            return false;
        }

        if (empty($this->getColorizerToolPath())) {
            return false;
        }

        if (! $this->colorizerCanExecute()) {
            return false;
        }

        return true;
    }

    abstract public function colorize(string $content): string;

    protected function getColorizerToolName(): string
    {
        return '';
    }

    protected function getColorizerToolPath(): string
    {
        $toolName = $this->getColorizerToolName();

        if ($toolName === '') {
            return '';
        }

        return (new ExecutableFinder())->find($toolName, $toolName, [
            '/usr/local/bin',
            '/opt/homebrew/bin',
        ]);
    }

    protected function colorizerCanExecute(): bool
    {
        $process = Process::fromShellCommandline($this->getColorizerToolPath());

        $process->run();

        return $process->isSuccessful();
    }
}
