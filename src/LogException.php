<?php

namespace Stock2Shop\Logger;

use Stock2Shop\Share\DTO;
use Throwable;

final class LogException extends Base
{

    public function __construct(Throwable $e)
    {
        parent::__construct();
        $this->log->level   = DTO\Log::LOG_LEVEL_ERROR;
        $this->log->message = $e->getMessage();
        $this->log->trace   = $e->getTrace();
    }

}
