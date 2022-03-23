<?php

it('can visit a URL', function () {
    $this->artisan('visit https://spatie.be')->assertSuccessful();
});
