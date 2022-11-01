<?php

declare(strict_types=1);

namespace Stock2Shop\Logger\Services;

interface ServiceInterface
{
    public static function terminateService();
    public static function getService();
}
