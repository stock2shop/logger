<?php

declare(strict_types=1);

namespace Stock2Shop\Logger;

use Stock2Shop\Logger\Domain\Log;

/**
 * @psalm-import-type Fields from Log
 */
class Custom
{
    /**
     * @param Fields $params
     */
    public static function log($params): void
    {
        $log = new Domain\Log($params);
        $logger = new Logger();
        $logger->log($log->level, $log->message, $params);
    }
}
