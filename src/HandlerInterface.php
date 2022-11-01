<?php

namespace Stock2Shop\Logger;

use Monolog\Handler;

interface HandlerInterface
{
    public static function get(): Handler\HandlerInterface;
}
