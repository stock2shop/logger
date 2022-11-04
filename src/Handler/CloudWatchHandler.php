<?php

namespace Stock2Shop\Logger\Handler;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Exception;
use Maxbanton\Cwh\Handler\CloudWatch;
use Monolog\Handler;
use Stock2Shop\Environment\Env;
use Stock2Shop\Share\Utils\Date;

final class CloudWatchHandler implements HandlerInterface
{
    private const LOG_CW_VERSION = 'LOG_CW_VERSION';
    private const LOG_CW_REGION = 'LOG_CW_REGION';
    private const LOG_CW_KEY = 'LOG_CW_KEY';
    private const LOG_CW_SECRET = 'LOG_CW_SECRET';
    private const LOG_CW_GROUP_NAME = 'LOG_CW_GROUP_NAME';
    private const LOG_CW_RETENTION_DAYS = 'LOG_CW_RETENTION_DAYS';
    private const LOG_CW_BATCH_SIZE = 'LOG_CW_BATCH_SIZE';

    /**
     * @return CloudWatch
     * @throws Exception
     */
    public static function get(): Handler\HandlerInterface
    {
        $client = new CloudWatchLogsClient([
            'version'     => Env::get(self::LOG_CW_VERSION),
            'region'      => Env::get(self::LOG_CW_REGION),
            'credentials' => [
                'key'    => Env::get(self::LOG_CW_KEY),
                'secret' => Env::get(self::LOG_CW_SECRET)
            ]
        ]);
        return new CloudWatch(
            $client,
            Env::get(self::LOG_CW_GROUP_NAME),
            substr(Date::getDateString(), 0, 10),
            (int) Env::get(self::LOG_CW_RETENTION_DAYS),
            (int) Env::get(self::LOG_CW_BATCH_SIZE)
        );
    }
}
