<?php

namespace Stock2Shop\Logger;


use Stock2Shop\Logger\Handler\HandlerInterface;
use Stock2Shop\Share\DTO;
use Throwable;

final class LogException extends Logger
{
    private string $origin;

    public function __construct(HandlerInterface $handler, string $origin)
    {
        parent::__construct($handler);
        $this->origin = $origin;
    }

    public function write(Throwable $e, int $channel_id, int $client_id): void
    {
        $log = new DTO\Log([
            'level'      => DTO\Log::LOG_LEVEL_ERROR,
            'message'    => $e->getMessage(),
            'trace'      => $e->getTrace(),
            'client_id'  => $client_id,
            'channel_id' => $channel_id,
            'log_to_es'  => true,
            'origin'     => $this->origin,
        ]);
        $this->handler->write(DTO\Log::LOG_LEVEL_ERROR, $log);
    }
}
