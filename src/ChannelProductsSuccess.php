<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Environment\Env;
use Stock2Shop\Share\DTO;

final class ChannelProductsSuccess
{
    public const TAG = 'sync_channel_products';
    public const MESSAGE = 'Channel Sync Products';

    /**
     * @param DTO\ChannelProduct[] $params
     */
    public static function log(array $params): void
    {
        $context = new Domain\Log([
            'level'      => Domain\Log::LOG_LEVEL_INFO,
            'message'    => self::MESSAGE,
            'origin'     => Env::get(EnvKey::LOG_CHANNEL),
            'log_to_es'  => true,
            'channel_id' => $params[0]->channel_id,
            'client_id'  => $params[0]->client_id,
            'tags'       => [self::TAG],
            'metric'     => count($params)
        ]);
        $logger  = new Logger();
        $logger->log($context->level, $context->message, (array)$context);
    }
}
