<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Environment\Env;
use Stock2Shop\Share\DTO;

final class LogChannelProductsFail implements LogInterface
{
    public const TAG = 'sync_channel_products';
    public const MESSAGE = 'Channel Sync Products Failed';

    /**
     * @param DTO\ChannelProduct[] $params
     */
    public static function log($params): void
    {
        $context             = new LogContext(
            level: LogContext::LOG_LEVEL_ERROR,
            message: self::MESSAGE,
            origin: Env::get(EnvKey::LOG_CHANNEL)
        );
        $context->log_to_es  = true;
        $context->channel_id = $params[0]->channel_id;
        $context->client_id  = $params[0]->client_id;
        $context->tags       = [self::TAG];
        $context->metric     = count($params);
        $logger              = new Logger();
        $logger->log($context->level, $context->message, (array)$context);
    }
}
