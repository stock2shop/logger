<?php

namespace Stock2Shop\Logger;

use Exception;
use InvalidArgumentException;
use Monolog\Logger as MonologLogger;
use Stock2Shop\Environment\Env;
use Stock2Shop\Logger\Formatter\Json;
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
        if (Env::isTrue(EnvKey::LOG_CW_ENABLED)) {
            $handlers[] = CloudWatchHandler::get();
        }
        if (Env::isTrue(EnvKey::LOG_FS_ENABLED)) {
            $handlers[] = FileHandler::get();
        }
        if (empty($handlers)) {
            throw new InvalidArgumentException('Logging not configured');
        }
        foreach ($handlers as $handler) {
            $handler->setFormatter(new Json());
        }

        // Create monolog instance with config
        parent::__construct(
            Env::get(EnvKey::LOG_CHANNEL),
            $handlers
        );
    }
}
