<?php

namespace App\Colorizers;

use Symfony\Component\Process\Process;

class HtmlColorizer extends Colorizer
{
    public function getColorizerToolName(): string
    {
        return 'bat';
    }

    public function colorize(string $content): string
    {
        $file = tmpfile();
        $path = stream_get_meta_data($file)['uri'];
        file_put_contents($path, $content);

        $process = Process::fromShellCommandline("cat {$path} | {$this->getColorizerToolPath()} --style=changes --force-colorization");

        $process->run();

        return $process->getOutput();
    }
}
