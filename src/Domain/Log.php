<?php

declare(strict_types=1);

namespace Stock2Shop\Logger\Domain;

use Stock2Shop\Share\Utils\Date;

/**
 * @psalm-type Level = "error"|"debug"|"info"|"critical"|"warning"
 * @psalm-type Fields = array{
 *     channel_id?: int|null,
 *     client_id?: int|null,
 *     attributes?: array<string, mixed>,
 *     created?: string,
 *     ip?: string,
 *     log_to_es?: bool,
 *     level: Level,
 *     message: string,
 *     method?: string,
 *     metric?: float,
 *     origin: string,
 *     remote_addr?: string,
 *     request_path?: string,
 *     source_id?: int,
 *     tags?: array<int, string>,
 *     trace?: array<int, string>,
 *     user_id?: int}
 */
class Log
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

    /** @psalm-var Level $level */
    public string $level;
    public string $message;
    public string $origin;
    public ?int $channel_id;
    public ?int $client_id;
    /** @var array<string, mixed> */
    public ?array $attributes;
    public string $created;
    public ?string $ip;
    public bool $log_to_es = false;
    public ?string $method;
    public ?float $metric;
    public ?string $remote_addr;
    public ?string $request_path;
    public ?int $source_id;
    /** @var array<int, string> */
    public array $tags;
    /** @var array<int, string> */
    public array $trace;
    public ?int $user_id;

    /**
     * @param Fields $data
     */
    public function __construct(array $data)
    {
        $this->channel_id   = $data['channel_id'] ?? null;
        $this->client_id    = $data['client_id']?? null;
        $this->attributes   = $data['attributes'] ?? [];
        $this->created      = $data['created'] ?? Date::getDateString();
        $this->ip           = $data['ip'] ?? null;
        $this->log_to_es    = $data['log_to_es'] ?? false;
        $this->level        = $data['level'];
        $this->message      = $data['message'];
        $this->method       = $data['method'] ?? null;
        $this->metric       = $data['metric'] ?? null;
        $this->origin       = $data['origin'];
        $this->remote_addr  = $data['remote_addr'] ?? null;
        $this->request_path = $data['request_path'] ?? null;
        $this->source_id    = $data['source_id'] ?? null;
        $this->tags         = $data['tags'] ?? [];
        $this->trace        = $data['trace'] ?? [];
        $this->user_id      = $data['user_id'] ?? null;
        if (!in_array($this->level, self::ALLOWED_LOG_LEVEL)) {
            throw new \InvalidArgumentException(sprintf('Invalid log level %s', $this->level));
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function flatten(): array
    {
        $arr = (array)$this;
        // attributes are flattened to root
        foreach ($arr['attributes'] as $k => $v) {
            $arr[$k] = $v;
        }
        unset($arr['attributes']);
        return $arr;
    }
}
