<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Logger\Handler\HandlerInterface;
use Stock2Shop\Share\DTO;

final class LogChannelProductsSuccess extends Logger
{
    public const TAG = 'sync_channel_products';
    public const MESSAGE = 'Channel Sync Products';

    public function __construct(HandlerInterface $handler)
    {
        parent::__construct($handler);
    }

    public function write(int $channel_id, int $client_id, int $count): void
    {
        $log = new DTO\Log([
            'level'      => DTO\Log::LOG_LEVEL_ERROR,
            'channel_id' => $channel_id,
            'client_id'  => $client_id,
            'message'    => self::MESSAGE,
            'tags'       => [self::TAG],
            'metric'     => $count,
            'log_to_es'  => true,
            // todo - below fields should be set dynamically and not hard coded
            'origin'     => 'origin',
            'created'    => "2022-02-02"
        ]);
        $this->handler->write(DTO\Log::LOG_LEVEL_ERROR, $log);
    }
}
