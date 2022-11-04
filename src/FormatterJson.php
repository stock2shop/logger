<?php

declare(strict_types=1);

namespace Stock2Shop\Logger;

use Monolog\Formatter;
use Stock2Shop\Logger\Log;

class FormatterJson extends Formatter\JsonFormatter
{
    public function format(array $record): string
    {
        $record = $this->normalize($record);
        $log    = new LogContext(
            level: $record['level'], message: $record['level'], origin: 's'
        );
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
        $record['context'] = $log->context;
        return $this->toJson($record, true) . ($this->appendNewline ? "\n" : '');
    }
}
