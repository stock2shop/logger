<?php

declare(strict_types=1);

namespace Stock2Shop\Logger\Handler\Config;

/**
 * Interface for setting Environment Variables
 */
interface LoaderInterface
{
    public function set(): void;

}
