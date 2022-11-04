<?php

declare(strict_types=1);

namespace Stock2Shop\Logger;

class Custom implements LogInterface
{
    /**
     * @param  Domain\Log $params
     * @return void
     */
    public static function log($params): void
    {
        $logger = new Logger();
        $logger->log($params->level, $params->message, (array) $params);
    }
}
