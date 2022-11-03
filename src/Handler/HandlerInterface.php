<?php

namespace Stock2Shop\Logger\Handler;

use Monolog\Handler;

interface HandlerInterface
{
    public static function get(): Handler\HandlerInterface;
}
