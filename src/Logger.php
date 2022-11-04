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
    /**
     * @throws Exception
     */
    public function __construct()
    {
        $handlers = [];
        if (Env::get(EnvKey::LOG_CW_ENABLED)) {
            $handlers[] = HandlerCloudWatch::get();
        }
        if (Env::get(EnvKey::LOG_FS_ENABLED)) {
            $handlers[] = HandlerFile::get();
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
