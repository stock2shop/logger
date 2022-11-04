<?php

declare(strict_types=1);

namespace Stock2Shop\Logger;

class Log implements LogInterface
{
    /**
     * @param LogContext $params
     * @return void
     */
    public static function log($params): void
    {
        $logger = new Logger();
        $logger->log($params->level, $params->message, (array) $params);
    }
}
