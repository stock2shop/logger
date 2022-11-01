<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Logger\Services\LogService;
use Stock2Shop\Share\DTO;

abstract class Base
{
    public DTO\Log $log;

    public function __construct()
    {
        $this->log = new DTO\Log([
            'level'     => DTO\Log::LOG_LEVEL_INFO,
            'log_to_es' => true,
            'message'   => '',
            'origin'    => Logger::LOG_ORIGIN,
            'client_id' => 0
        ]);
    }

    public function save(): void
    {
        $logger = LogService::getService();
        $logger->write($this->log);
    }
}
