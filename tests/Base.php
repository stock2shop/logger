<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use PHPUnit\Framework\TestCase;
use Stock2Shop\Logger\Handler\Config;

class Base extends TestCase
{
    public function getLogs(string $file): array
    {
        $logs = file_get_contents($file);
        return explode("\n", $logs);
    }

    public function resetLogs(string $file)
    {
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
