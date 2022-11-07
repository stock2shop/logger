<?php

namespace Stock2Shop\Logger\Handler;

use Aws\CloudWatchLogs\CloudWatchLogsClient;
use Exception;
use Maxbanton\Cwh\Handler\CloudWatch;
use Monolog\Handler;
use Stock2Shop\Environment\Env;
use Stock2Shop\Logger\EnvKey;
use Stock2Shop\Share\Utils\Date;

final class CloudWatchHandler implements HandlerInterface
{
    /**
     * @return CloudWatch
     * @throws Exception
     */
    public static function get(): Handler\HandlerInterface
    {
        $client = new CloudWatchLogsClient([
            'version'     => Env::get(EnvKey::LOG_CW_VERSION),
            'region'      => Env::get(EnvKey::LOG_CW_REGION),
            'credentials' => [
                'key'    => Env::get(EnvKey::LOG_CW_KEY),
                'secret' => Env::get(EnvKey::LOG_CW_SECRET)
            ]
        ]);
        return new CloudWatch(
            $client,
            Env::get(EnvKey::LOG_CW_GROUP_NAME),
            substr(Date::getDateString(), 0, 10),
            (int) Env::get(EnvKey::LOG_CW_RETENTION_DAYS),
            (int) Env::get(EnvKey::LOG_CW_BATCH_SIZE)
        );
    }
}
