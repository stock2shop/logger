<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use PHPUnit\Framework\TestCase;
use Stock2Shop\Environment\Env;
use Stock2Shop\Logger\EnvKey;

/**
 * @psalm-suppress PropertyNotSetInConstructor:
 */
class Base extends TestCase
{
    protected const LOG_CHANNEL = 'Logger';

    public function getLogs(): array
    {
        $dir  = Env::get(EnvKey::LOG_FS_DIR);
        $file = Env::get(EnvKey::LOG_FS_FILE_NAME);
        $file = $dir . $file;
        $logs = file_get_contents($file);
        return explode("\n", $logs);
    }

    public function resetLogs(): void
    {
        $dir  = Env::get(EnvKey::LOG_FS_DIR);
        $file = Env::get(EnvKey::LOG_FS_FILE_NAME);
        $file = $dir . $file;
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
