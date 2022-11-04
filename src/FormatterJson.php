<?php

declare(strict_types=1);

namespace Stock2Shop\Logger;

use Monolog\Formatter;
use Monolog\Logger;

class FormatterJson extends Formatter\JsonFormatter
{
    private static $levels = [
        Logger::DEBUG     => 'DEBUG',
        Logger::INFO      => 'INFO',
        Logger::NOTICE    => 'NOTICE',
        Logger::WARNING   => 'WARNING',
        Logger::ERROR     => 'ERROR',
        Logger::CRITICAL  => 'CRITICAL',
        Logger::ALERT     => 'ALERT',
        Logger::EMERGENCY => 'EMERGENCY',
    ];

    public function format(array $record): string
    {
        // normalise record
        $record          = $this->normalize($record);

        // create LogContext and set property values
        // if defined on the record
        $log             = new LogContext(
            level: self::$levels[$record['level']],
            message: $record['message'],
            origin: $record['message']
        );
        $log->channel_id = $record['context']['channel_id'] ?? null;
        $log->client_id  = $record['context']['client_id'] ?? null;
        $log->created      = $record['context']['created'] ?? null;
        $log->ip           = $record['context']['ip'] ?? null;
        $log->log_to_es    = $record['context']['log_to_es'] ?? null;
        $log->method       = $record['context']['method'] ?? null;
        $log->metric       = $record['context']['metric'] ?? null;
        $log->remote_addr  = $record['context']['remote_addr'] ?? null;
        $log->request_path = $record['context']['request_path'] ?? null;
        $log->source_id    = $record['context']['source_id'] ?? null;
        $log->tags    = $record['context']['tags'] ?? null;
        $log->trace   = $record['context']['trace'] ?? null;
        $log->user_id = $record['context']['user_id'] ?? null;

        // Transform record to be consistent with Stock2Shop.
        // Property names must be the same.
        // Flatten structure
        foreach ($log as $k => $v) {
            // ignore nulls / empty and context
            if ($k === 'context') {
                continue;
            }
            if (
                is_null($v) ||
                $v === '') {
                continue;
            }
            if (
                is_array($v) &&
                empty($v)
            ) {
                continue;
            }
            $record[$k] = $v;
        }
        $record['context'] = $log->context ?? null;
        return $this->toJson($record, true) . ($this->appendNewline ? "\n" : '');
    }
}
