<?php

namespace Stock2Shop\Logger\Handler;

use Monolog\Handler;
use Monolog\Handler\StreamHandler;
use Stock2Shop\Logger\Handler\Config\Env;
use Stock2Shop\Logger\Handler\Config\EnvKey;
use Stock2Shop\Logger\Logger;
use Stock2Shop\Share\DTO\Log;

class HandlerFile implements HandlerInterface
{
    private string $filename;

    public function __construct(string $filename)
    {
        if ($filename == '') {
            throw new \UnexpectedValueException('Log file name must be set');
        }

        $dir = dirname($filename);
        if (!file_exists($dir)) {
            $status = mkdir($dir, 0777, true);
            if ($status === false && !is_dir($dir)) {
                throw new \UnexpectedValueException(sprintf('There is no existing directory at "%s"', $dir));
            }
        }
        $this->filename = $filename;
    }

    public function write(string $level, Log $log)
    {
        if (!in_array($level, Logger::ALLOWED_LOG_LEVEL)) {
            throw new \InvalidArgumentException(sprintf('Invalid log level %s', $level));
        }

        file_put_contents($this->filename, json_encode($log) . PHP_EOL, FILE_APPEND);
    }
}
