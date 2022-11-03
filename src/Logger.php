<?php

namespace Stock2Shop\Logger;

use Psr\Log\AbstractLogger;
use Stock2Shop\Logger\Handler\HandlerInterface;
use Stock2Shop\Share\DTO\Log;

class Logger extends AbstractLogger
{
    public const LOG_LEVEL_ERROR = 'error';
    public const LOG_LEVEL_DEBUG = 'debug';
    public const LOG_LEVEL_INFO = 'info';
    public const LOG_LEVEL_CRITICAL = 'critical';
    public const LOG_LEVEL_WARNING = 'warning';
    public const ALLOWED_LOG_LEVEL = [
        self::LOG_LEVEL_ERROR,
        self::LOG_LEVEL_DEBUG,
        self::LOG_LEVEL_INFO,
        self::LOG_LEVEL_CRITICAL,
        self::LOG_LEVEL_WARNING
    ];

    public HandlerInterface $handler;

    public function __construct(HandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function log($level, \Stringable|string $message, array $context = []): void
    {
        $log = new Log([
            'channel_id'   => $context['channel_id'],
            'client_id'    => $context['client_id'],
            'context'      => $context['context'],
            'created'      => $context['created'],
            'ip'           => $context['ip'],
            'log_to_es'    => $context['log_to_es'],
            'level'        => $context['level'],
            'message'      => $message,
            'method'       => $context['method'],
            'metric'       => $context['metric'],
            'origin'       => $context['origin'],
            'remote_addr'  => $context['remote_addr'],
            'request_path' => $context['request_path'],
            'source_id'    => $context['source_id'],
            'tags'         => $context['tags'],
            'trace'        => $context['trace'],
            'user_id'      => $context['user_id'],
        ]);
        $this->handler->write($level, $log);
    }
}
