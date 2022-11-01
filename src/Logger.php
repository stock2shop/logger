<?php

namespace Stock2Shop\Logger;

use Exception;
use InvalidArgumentException;
use Monolog\Logger as MonologLogger;
use Stock2Shop\Share\DTO;
use Stock2Shop\Logger\Config\Env;
use Stock2Shop\Logger\Config\EnvKey;

class Logger extends MonologLogger
{
    public const LOG_ORIGIN = 'Core';
    public const LOG_LEVEL_MAP = [
        DTO\Log::LOG_LEVEL_ERROR    => MonologLogger::ERROR,
        DTO\Log::LOG_LEVEL_DEBUG    => MonologLogger::DEBUG,
        DTO\Log::LOG_LEVEL_INFO     => MonologLogger::INFO,
        DTO\Log::LOG_LEVEL_CRITICAL => MonologLogger::CRITICAL,
        DTO\Log::LOG_LEVEL_WARNING  => MonologLogger::WARNING,
    ];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        if (
            Env::get(EnvKey::LOG_CW_KEY) &&
            Env::get(EnvKey::LOG_CW_SECRET)
        ) {
            $handler = HandlerCloudWatch::get();
        } else {
            if (
                Env::get(EnvKey::LOG_FS_DIR) &&
                Env::get(EnvKey::LOG_FS_FILE_NAME)
            ) {
                $handler = HandlerFile::get();
            }
        }
        if (!isset($handler)) {
            throw new InvalidArgumentException('Logging not configured');
        }
        $handler->setFormatter(new FormatterJson());

        // Create monolog instance with config
        parent::__construct(
            Env::get(EnvKey::LOG_CHANNEL),
            [$handler]
        );
    }

    public function write(DTO\Log $log)
    {
        $level       = self::LOG_LEVEL_MAP[$log->level];
        $log->origin = self::LOG_ORIGIN;
        $this->addRecord(
            $level,
            $log->message,
            (array)$log
        );
    }
}
