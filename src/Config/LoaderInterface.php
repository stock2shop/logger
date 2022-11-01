<?php

declare(strict_types=1);

namespace Stock2Shop\Logger\Config;

/**
 * Interface for setting Environment Variables
 */
interface LoaderInterface
{
    public function set(): void;

}
