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
        $record = $this->normalize($record);

        // create LogContext and set property values
        // if defined on the record
        $log = new  Domain\Log($record['context']);

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
