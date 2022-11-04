<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Environment\Env;
use Throwable;

final class Exception implements LogInterface
{
    /**
     * @param Throwable $params
     * @return void
     */
    public static function log($params): void
    {
        $context = new Domain\Log([
            'level'     => Domain\Log::LOG_LEVEL_ERROR,
            'message'   => $params->getMessage(),
            'origin'    => Env::get(EnvKey::LOG_CHANNEL),
            'trace'     => $params->getTrace(),
            'client_id' => 0,
        ]);
        $logger  = new Logger();
        $logger->log($context->level, $context->message, (array)$context);
    }
}
