<?php

declare(strict_types=1);

namespace Stock2Shop\Logger;

use Exception;
use Psr\Log\LogLevel;
use Stock2Shop\Share\Utils\Date;
use Traversable;

class LogContext
{
    public const LOG_LEVEL_ERROR = 'error';
    public const LOG_LEVEL_DEBUG = 'debug';
    public const LOG_LEVEL_INFO = 'info';
    public const LOG_LEVEL_CRITICAL = 'critical';
    public const LOG_LEVEL_WARNING = 'warning';

    private const ALLOWED_LOG_LEVEL = [
        self::LOG_LEVEL_ERROR,
        self::LOG_LEVEL_DEBUG,
        self::LOG_LEVEL_INFO,
        self::LOG_LEVEL_CRITICAL,
        self::LOG_LEVEL_WARNING
    ];

    public ?int $channel_id;
    public ?int $client_id;
    /** @var array|null associative array */
    public ?array $context;
    public ?string $created;
    public ?string $ip;
    public bool $log_to_es = false;
    public ?string $method;
    public ?float $metric;
    public ?string $remote_addr;
    public ?string $request_path;
    public ?int $source_id;
    /** @var string[]|null */
    public ?array $tags;
    public ?array $trace;
    public ?int $user_id;

    public function __construct(
        public string $level,
        public string $message,
        public string $origin
    ) {
        $this->created = Date::getDateString();
        if(!in_array($this->level, self::ALLOWED_LOG_LEVEL)) {
            throw new \InvalidArgumentException('Invalid Log Level ');
        }
    }

}
