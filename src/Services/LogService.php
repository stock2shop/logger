<?php

declare(strict_types=1);

namespace Stock2Shop\Logger\Services;

use Stock2Shop\Logger\Logger;

class LogService implements ServiceInterface
{
    private static ?Logger $logger;

    public static function init()
    {
        self::$logger = new Logger();
    }

    public static function terminateService()
    {
        if (isset(self::$logger)) {
            self::$logger->reset();
        }
    }

    public static function getService(): Logger
    {
        if (!isset(self::$logger)) {
            self::init();
        }
        return self::$logger;
    }
}
