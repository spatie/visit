<?php

require_once __DIR__ . '/../vendor/autoload.php';

putenv('APP_ENV=production');
putenv('APP_DEBUG=true');

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/../')
);

$app->configure('app');

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) use ($app) {
    $router->get('booted', fn() => 'app has booted');

    $configFile = __DIR__ . "/config.json";

    $config = json_decode(file_get_contents($configFile), true);

    $routesFile = __DIR__ . "/routeFiles/{$config['routes']}.php";

    require $routesFile;
});

$app->run();
