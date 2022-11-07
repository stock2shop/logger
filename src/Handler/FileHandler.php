<?php

namespace Stock2Shop\Logger\Handler;

use Monolog\Handler;
use Monolog\Handler\StreamHandler;
use Stock2Shop\Environment\Env;
use Stock2Shop\Logger\EnvKey;

final class FileHandler implements HandlerInterface
{
    /**
     * @return StreamHandler
     */
    public static function get(): Handler\HandlerInterface
    {
        $dir  = Env::get(EnvKey::LOG_FS_DIR);
        $file = Env::get(EnvKey::LOG_FS_FILE_NAME);
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $path = sprintf('%s/%s', $dir, $file);
        return new StreamHandler($path);
    }
}
