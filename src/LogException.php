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

    public function save(): void
    {
        $logger = new Logger();
        $logger->write($this->log);
    }
}
