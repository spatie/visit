<?php

use Tests\Support\Visit;

it('can visit a URL', function () {
    $visit = Visit::run('http://localhost:8282');

    $visit
        ->expectSuccess()
        ->expectOutputContains(
            'this is the homepage',
            'GET http://localhost:8282',

        );
});
