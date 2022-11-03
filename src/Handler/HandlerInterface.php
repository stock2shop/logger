<?php

namespace Stock2Shop\Logger\Handler;

use Monolog\Handler;
use Stock2Shop\Share\DTO\DTO;
use Stock2Shop\Share\DTO\Log;

interface HandlerInterface
{
    public function write(string $level, Log $log);
}
