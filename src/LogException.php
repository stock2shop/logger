<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Environment\Env;
use Throwable;

final class LogException implements LogInterface
{
    public Log $log;

    private const LOG_CHANNEL = 'LOG_CHANNEL';

    public function __construct(Throwable $e)
    {
        $this->log = new Log([
            'level'     => Log::LOG_LEVEL_ERROR,
            'log_to_es' => true,
            'message'   => $e->getMessage(),
            'origin'    => Env::get(self::LOG_CHANNEL),
            'client_id' => 0,
            'trace'     => $e->getTrace()
        ]);
    }


    /**
     * @param Throwable $params
     * @return void
     */
    public static function log($params): void
    {
        $context            = new LogContext(
            level: LogContext::LOG_LEVEL_ERROR,
            message: $params->getMessage(),
            origin: Env::get(EnvKey::LOG_CHANNEL)
        );
        $context->trace     = $params->getTrace();
        $context->client_id = 0;
        $logger             = new Logger();
        $logger->log($context->level, $context->message, (array)$context);
    }
}
