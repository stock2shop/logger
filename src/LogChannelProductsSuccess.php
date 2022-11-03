<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Environment\Env;
use Stock2Shop\Share\DTO;

final class LogChannelProductsSuccess implements LogInterface
{
    public const TAG = 'sync_channel_products';
    public const MESSAGE = 'Channel Sync Products';

    public Log $log;

    private const LOG_CHANNEL = 'LOG_CHANNEL';

    /**
     * @param DTO\ChannelProduct[] $channelProducts
     */
    public function __construct(array $channelProducts)
    {
        $this->log = new Log([
            'log_to_es'  => true,
            'origin'     => Env::get(self::LOG_CHANNEL),
            'level'      => Log::LOG_LEVEL_INFO,
            'channel_id' => $channelProducts[0]->channel_id,
            'client_id'  => $channelProducts[0]->client_id,
            'message'    => self::MESSAGE,
            'tags'       => [self::TAG],
            'metric'     => count($channelProducts),
        ]);
    }

    public function save(): void
    {
        $logger = new Logger();
        $logger->write($this->log);
    }
}
