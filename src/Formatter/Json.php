<?php

declare(strict_types=1);

namespace Stock2Shop\Logger\Formatter;

use Monolog\Formatter;
use Stock2Shop\Logger\Domain;

class Json extends Formatter\JsonFormatter
{
    public function format(array $record): string
    {
        // normalise record
        $record = $this->normalize($record);

        // Recreate the log from context
        $log = new  Domain\Log($record['context']);
        return $this->toJson($log->flatten(), true) . ($this->appendNewline ? "\n" : '');
    }
}
