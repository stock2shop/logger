<?php

namespace Stock2Shop\Logger\Handler;

use Monolog\Handler;
use Monolog\Handler\StreamHandler;
use Stock2Shop\Environment\Env;

final class FileHandler implements HandlerInterface
{
    private const LOG_FS_DIR = 'LOG_FS_DIR';
    private const LOG_FS_FILE_NAME = 'LOG_FS_FILE_NAME';

    /**
     * @return StreamHandler
     */
    public static function get(): Handler\HandlerInterface
    {
        $dir  = Env::get(self::LOG_FS_DIR);
        $file = Env::get(self::LOG_FS_FILE_NAME);
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        $path = sprintf('%s/%s', $dir, $file);
        return new StreamHandler($path);
    }
}
