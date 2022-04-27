<?php

namespace App\Colorizers;

use Symfony\Component\Process\Process;

class JsonColorizer extends Colorizer
{
    public function canColorize(string $contentType): bool
    {
        if (! parent::canColorize($contentType)) {
            return false;
        }

        return str_contains($contentType, 'json');
    }

    public function getColorizerToolName(): string
    {
        return 'jq';
    }

    public function colorize(string $content): string
    {
        $file = tmpfile();
        $path = stream_get_meta_data($file)['uri'];
        file_put_contents($path, $content);

        $process = Process::fromShellCommandline("cat {$path} | {$this->getColorizerToolPath()} -C");

        $process->run();

        return $process->getOutput();
    }
}
