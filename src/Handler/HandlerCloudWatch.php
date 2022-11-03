<?php
//
//namespace Stock2Shop\Logger\Handler;
//
//use Aws\CloudWatchLogs\CloudWatchLogsClient;
//use Exception;
//use Maxbanton\Cwh\Handler\CloudWatch;
//use Monolog\Handler;
//use Stock2Shop\Logger\Handler\Config\Env;
//use Stock2Shop\Logger\Handler\Config\EnvKey;
//use Stock2Shop\Share\Utils\Date;
//
//final class HandlerCloudWatch implements HandlerInterface
//{
//    /**
//     * @return CloudWatch
//     * @throws Exception
//     */
//    public static function get(): Handler\HandlerInterface
//    {
//        $client = new CloudWatchLogsClient([
//            'version'     => Env::get(EnvKey::LOG_CW_VERSION),
//            'region'      => Env::get(EnvKey::LOG_CW_REGION),
//            'credentials' => [
//                'key'    => Env::get(EnvKey::LOG_CW_KEY),
//                'secret' => Env::get(EnvKey::LOG_CW_SECRET)
//            ]
//        ]);
//        return new CloudWatch(
//            $client,
//            Env::get(EnvKey::LOG_CW_GROUP_NAME),
//            substr(Date::getDateString(Date::FORMAT), 0, 10),
//            Env::get(EnvKey::LOG_CW_RETENTION_DAYS),
//            Env::get(EnvKey::LOG_CW_BATCH_SIZE)
//        );
//    }
//}
