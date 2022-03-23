<?php

namespace Tests\Support;

use Symfony\Component\Process\Process;

class Visit
{
    protected string $command;

    protected Process $process;

    protected string $output;
    protected string $errorOutput;

    public static function run(string $command): self
    {
        $visit = new self($command);

        $visit->runProcess();

        return $visit;
    }

    protected function __construct(string $command)
    {
        $this->command = $command;

        $this->process = Process::fromShellCommandline("./visit {$this->command}");
    }

    protected function runProcess(): self
    {
        $this->process->run();

        $this->output = $this->process->getOutput();

        $this->errorOutput = $this->process->getErrorOutput();

        return $this;
    }

    public function expectSuccess(): self
    {
        expect($this->process->isSuccessful())->toBeTrue();

        return $this;
    }

    public function expectOutputContains(string ...$expectedSubstring): self
    {
        expect($this->output)->toContain(...$expectedSubstring);

        return $this;
    }

    public function expectOutputNotContains(string ...$expectedSubstring): self
    {
        expect($this->output)->not()->toContain(...$expectedSubstring);

        return $this;
    }

    public function dd()
    {
        dd($this->output);
    }


}
