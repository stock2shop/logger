<?php

namespace Stock2Shop\Logger;

use Exception;
use InvalidArgumentException;
use Monolog\Logger as MonologLogger;
use Stock2Shop\Environment\Env;
use Stock2Shop\Logger\Handler\HandlerCloudWatch;
use Stock2Shop\Logger\Handler\HandlerFile;

class Logger extends MonologLogger
{
    public const LOG_LEVEL_MAP = [
        Log::LOG_LEVEL_ERROR    => MonologLogger::ERROR,
        Log::LOG_LEVEL_DEBUG    => MonologLogger::DEBUG,
        Log::LOG_LEVEL_INFO     => MonologLogger::INFO,
        Log::LOG_LEVEL_CRITICAL => MonologLogger::CRITICAL,
        Log::LOG_LEVEL_WARNING  => MonologLogger::WARNING,
    ];

    private const LOG_CW_ENABLED = 'LOG_CW_ENABLED';
    private const LOG_FS_ENABLED = 'LOG_FS_ENABLED';
    private const LOG_CHANNEL = 'LOG_CHANNEL';

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (Env::get(self::LOG_CW_ENABLED)) {
            $handler = HandlerCloudWatch::get();
        } elseif (Env::get(self::LOG_FS_ENABLED)) {
            $handler = HandlerFile::get();
        }
        if (!isset($handler)) {
            throw new InvalidArgumentException('Logging not configured');
        }
        $handler->setFormatter(new FormatterJson());

        // Create monolog instance with config
        parent::__construct(
            Env::get(self::LOG_CHANNEL),
            [$handler]
        );
    }


    public function write(Log $log)
    {
        $level       = self::LOG_LEVEL_MAP[$log->level];
        $log->origin = self::getName();
        $this->addRecord(
            $level,
            $log->message,
            (array)$log
        );
    }
}
