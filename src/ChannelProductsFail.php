<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Environment\Env;
use Stock2Shop\Share\DTO;
use Stock2Shop\Logger\Domain;

final class ChannelProductsFail
{
    public const TAG = 'sync_channel_products';
    public const MESSAGE = 'Channel Sync Products Failed';

    /**
     * @param DTO\ChannelProduct[] $params
     */
    public static function log(array $params): void
    {
        $context = new Domain\Log([
            'level'      => Domain\Log::LOG_LEVEL_ERROR,
            'message'    => self::MESSAGE,
            'origin'     => Env::get(EnvKey::LOG_CHANNEL),
            'log_to_es'  => true,
            'channel_id' => $params[0]->channel_id,
            'client_id'  => $params[0]->client_id,
            'tags'       => [self::TAG],
            'metric'     => count($params),
        ]);
        $logger  = new Logger();
        $logger->log($context->level, $context->message, (array)$context);
    }
}
