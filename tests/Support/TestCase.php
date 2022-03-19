<?php

namespace Tests\Support;

use LaravelZero\Framework\Testing\TestCase as BaseTestCase;
use Tests\Support\Server\Server;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        Server::boot();
    }
}
