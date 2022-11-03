<?php

declare(strict_types=1);

namespace Stock2Shop\Logger\Handler\Config;

class Env
{
    /**
     * Set Environment Variables
     */
    public static function set(LoaderInterface $loader): void
    {
        $loader->set();
    }

    /**
     * Fetches Environment Variable
     */
    public static function get(EnvKey $key): string|false
    {
        if (
            isset($_SERVER[$key->value]) &&
            is_string($_SERVER[$key->value]) &&
            $_SERVER[$key->value] !== ''
        ) {
            return $_SERVER[$key->value];
        }
        return false;
    }
}
