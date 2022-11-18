<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Environment\Env;
use Throwable;

/**
 * @psalm-import-type Fields from Domain\Log
 */
final class Exception
{
    /**
     * @param Throwable $e
     * @param Fields|array $params
     * @return void
     */
    public static function log(Throwable $e, array $params = []): void
    {
        $arr     = array_merge($params, [
            'level'     => Domain\Log::LOG_LEVEL_ERROR,
            'message'   => $e->getMessage(),
            'origin'    => Env::get(EnvKey::LOG_CHANNEL),
            'trace'     => $e->getTrace(),
            'log_to_es'  => true,
            'client_id' => 0,
        ]);
        $context = new Domain\Log($arr);
        $logger  = new Logger();
        $logger->log($context->level, $context->message, (array)$context);
    }
}
