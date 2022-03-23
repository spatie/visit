<?php

namespace Tests\Support;

use Artisan;

class ArtisanOutput
{
    public static string|null $output = null;

    public static function get()
    {
        if (self::$output === null) {
            self::$output = Artisan::output();
        }

        return self::$output;
    }

    public static function clear()
    {
        self::$output = null;
    }
}
