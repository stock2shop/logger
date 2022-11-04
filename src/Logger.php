<?php

namespace Stock2Shop\Logger;

use Exception;
use InvalidArgumentException;
use Monolog\Logger as MonologLogger;
use Stock2Shop\Environment\Env;
use Stock2Shop\Logger\Handler\CloudWatchHandler;
use Stock2Shop\Logger\Handler\FileHandler;

class Logger extends MonologLogger
{
    /**
     * @throws Exception
     */
    public function __construct()
    {
        $handlers = [];
        if (Env::get(EnvKey::LOG_CW_ENABLED) == 'true') {
            $handlers[] = CloudWatchHandler::get();
        }
        if (Env::get(EnvKey::LOG_FS_ENABLED) == 'true') {
            $handlers[] = FileHandler::get();
        }
        if (empty($handlers)) {
            throw new InvalidArgumentException('Logging not configured');
        }
        foreach ($handlers as $handler) {
            $handler->setFormatter(new FormatterJson());
        }

        // Create monolog instance with config
        parent::__construct(
            Env::get(EnvKey::LOG_CHANNEL),
            $handlers
        );
    }
}
