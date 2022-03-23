<?php

namespace Tests\Support\Server;

use GuzzleHttp\Client;
use Throwable;

class Server
{
    protected Client $client;

    public function __construct(Client $client = null)
    {
        static::boot();

        $this->client = $client ?? new Client();
    }

    public static function boot()
    {
        if (! file_exists(__DIR__.'/vendor')) {
            exec('cd "'.__DIR__.'"; composer install');
        }

        if (static::serverHasBooted()) {
            return;
        }

        $startServerCommand = '/opt/homebrew/bin/php -S '.rtrim(static::getServerUrl(), '/').' -t ./tests/Support/Server/public > /dev/null 2>&1 & echo $!';

        $pid = exec($startServerCommand);
        while (! static::serverHasBooted()) {
            sleep(1);
        }

        register_shutdown_function(function () use ($pid) {
            @exec("kill {$pid} 2>/dev/null");
        });
    }

    public static function getServerUrl(string $endPoint = ''): string
    {
        return 'localhost:'.getenv('TEST_SERVER_PORT').'/'.$endPoint;
    }

    public static function serverHasBooted(): bool
    {
        $context = stream_context_create(['http' => [
            'timeout' => 1,
        ]]);

        try {
            $result = file_get_contents('http://'.self::getServerUrl('booted'), false, $context) != false;
        } catch (Throwable $exception) {
            $result = false;
        }

        return $result;
    }
}
