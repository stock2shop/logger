<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use PHPUnit\Framework\TestCase;
use Stock2Shop\Logger\Config;

class Base extends TestCase
{
    protected function setUp(): void
    {
        // Set Environment variables from .env file
        $dotEnv = new Config\LoaderDotenv(__DIR__ . '../../');
        Config\Env::set($dotEnv);
    }

    public function getLogs(): array
    {
        $dir  = Config\Env::get(Config\EnvKey::LOG_FS_DIR);
        $file = Config\Env::get(Config\EnvKey::LOG_FS_FILE_NAME);
        $file = $dir . $file;
        $logs = file_get_contents($file);
        return explode("\n", $logs);
    }

    public function resetLogs()
    {
        $dir  = Config\Env::get(Config\EnvKey::LOG_FS_DIR);
        $file = Config\Env::get(Config\EnvKey::LOG_FS_FILE_NAME);
        $file = $dir . $file;
        if (file_exists($file)) {
            unlink($file);
        }
    }
}
