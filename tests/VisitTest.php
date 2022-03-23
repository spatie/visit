<?php

use Tests\Support\Visit;

it('can visit an URL', function () {
    Visit::run('http://localhost:8282')
        ->expectSuccess()
        ->expectOutputContains(
            'GET http://localhost:8282',
            'this is the homepage',
        );
});

it('it will use https by default', function () {
    Visit::run('spatie.be')
        ->expectSuccess()
        ->expectOutputContains('GET https://spatie.be');
});

it('it can explicitly use http', function () {
    Visit::run('http://spatie.be')
        ->expectSuccess()
        ->expectOutputContains('GET http://spatie.be', 'Redirecting To: https://spatie.be');
});

it('can follow redirects', function () {
    Visit::run('http://spatie.be --follow-redirects')
        ->expectSuccess()
        ->expectOutputContains(
            'GET https://spatie.be',
            'Redirects',
            '200 http://spatie.be',
            '->️ https://spatie.be/'
        );
});

it('can use a different http verb', function () {
    Visit::run('http://localhost:8282/post-route --method=post')
        ->expectSuccess()
        ->expectOutputContains(
            'POST http://localhost:8282',
            'post content',
        );
});

it('accepts the no-color option', function () {
    Visit::run('http://localhost:8282 --no-color')
        ->expectSuccess()
        ->expectOutputContains(
            'GET http://localhost:8282',
            'this is the homepage',
        );
});

it('can strip away the html', function () {
    Visit::run('http://localhost:8282/html')
        ->expectSuccess()
        ->expectOutputContains(
            'GET http://localhost:8282',
            'div content',
        )
        ->expectOutputNotContains('html', '<div>', '</div>');
});

it('can show the response only', function () {
    Visit::run('http://localhost:8282 --only-response')
        ->expectSuccess()
        ->expectOutputContains('this is the homepage', )
        ->expectOutputNotContains('GET http://localhost:8282', );
});

it('can show the stats only', function () {
    Visit::run('http://localhost:8282 --only-stats')
        ->expectSuccess()
        ->expectOutputNotContains('this is the homepage', )
        ->expectOutputContains('GET http://localhost:8282', );
});

it('can show json', function () {
    Visit::run('http://localhost:8282/json')
        ->expectSuccess()
        ->expectOutputContains(
            'GET http://localhost:8282/json',
            'first',
            'value1',
            'second',
            'value2',
        );
});

it('can filter json', function () {
    Visit::run('http://localhost:8282/json --filter=first')
        ->expectSuccess()
        ->expectOutputContains(
            'GET http://localhost:8282/json',
            'value1',
        )
        ->expectOutputNotContains('first', 'second', 'value2');
});

it('can post a json payload', function () {
    $payload = json_encode(['myKey' => 'myValue']);

    Visit::run("http://localhost:8282/json-payload --method=post --payload='{$payload}'")
        ->expectOutputContains(
            'POST http://localhost:8282/json',
            'myKey',
            'myValue',
        );
});

it('will display an error message when passing an invalid url', function() {
    Visit::run('/')
        ->expectOutputContains('You should pass a valid URL.');
});

it('will display an error message when passing an invalid method', function() {
    Visit::run('http://localhost:8282 --method=invalid')
        ->expectOutputContains('is not a valid method name');
});

it('will display an error message when passing an invalid json', function() {
    Visit::run('http://localhost:8282 --method=post --payload=invalid')
        ->expectOutputContains('You should pass valid JSON');
});
