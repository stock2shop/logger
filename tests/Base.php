<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use PHPUnit\Framework\TestCase;
use Stock2Shop\Environment\Env;

class Base extends TestCase
{
    private const LOG_FS_DIR = 'LOG_FS_DIR';
    private const LOG_FS_FILE_NAME = 'LOG_FS_FILE_NAME';

    public function getLogs(): array
    {
        $dir  = Env::get(self::LOG_FS_DIR);
        $file = Env::get(self::LOG_FS_FILE_NAME);
        $file = $dir . $file;
        $logs = file_get_contents($file);
        return explode("\n", $logs);
    }

    public function resetLogs()
    {
        $dir  = Env::get(self::LOG_FS_DIR);
        $file = Env::get(self::LOG_FS_FILE_NAME);
        $file = $dir . $file;
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
