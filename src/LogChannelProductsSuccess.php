<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Share\DTO;

final class LogChannelProductsSuccess extends Base
{
    public const TAG = 'sync_channel_products';
    public const MESSAGE = 'Channel Sync Products';

    /**
     * @param DTO\ChannelProduct[] $channelProducts
     */
    public function __construct(array $channelProducts)
    {
        parent::__construct();
        $this->log->channel_id = $channelProducts[0]->channel_id;
        $this->log->client_id = $channelProducts[0]->client_id;
        $this->log->message = self::MESSAGE;
        $this->log->tags   = [self::TAG];
        $this->log->metric = count($channelProducts);
    }
}
