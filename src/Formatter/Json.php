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
        $flattened = $log->flatten();
        foreach ($flattened as $k => $v) {
            // if item has no value set, or is an empty array.
            // We should drop the key from the log
            if (!isset($v) || (is_array($v) && count($v) == 0)) {
                unset($flattened[$k]);
            }
        }
        return $this->toJson($flattened, true) . ($this->appendNewline ? "\n" : '');
    }
}
