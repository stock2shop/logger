<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use Stock2Shop\Environment\Env;
use Stock2Shop\Environment\LoaderArray;
use Stock2Shop\Logger\Domain;
use Stock2Shop\Logger\Custom;
use Stock2Shop\Share\Utils\Date;

/**
 * @psalm-suppress PropertyNotSetInConstructor:
 */
class CustomTest extends Base
{
    /**
     * @dataProvider partialLogDataProvider
     * @param array<string, mixed> $keysToAdd
     * @param string[] $missingKeys
     */
    public function testPartialLog(array $keysToAdd, array $missingKeys): void
    {
        // test writing logs to file
        $loader = new LoaderArray([
            'LOG_CHANNEL'      => 'Logger',
            'LOG_FS_DIR'       => sprintf('%s/output/', __DIR__),
            'LOG_FS_ENABLED'   => 'true',
            'LOG_FS_FILE_NAME' => 'system.log'
        ]);
        Env::set($loader);

        // clean test file
        $this->resetLogs();

        // create log based off of parameter keysToAdd
        $logContext = [];
        foreach ($keysToAdd as $k => $v) {
            $logContext[$k] = $v;
        }
        /**
         * @psalm-suppress ArgumentTypeCoercion
         */
        Custom::log($logContext);

        $parts = $this->getLogs();

        // 4 lines, one is space at end
        $this->assertCount(2, $parts);
        $this->assertEquals('', $parts[1]);
        $obj = json_decode($parts[0], true);

        // Assert that keys provided have been written
        foreach ($keysToAdd as $key => $value) {
            $this->assertEquals($value, $obj[$key]);
        }

        // Assert that keys with default values have been written
        $this->assertEquals($keysToAdd['log_to_es'] ?? false, $obj['log_to_es']);
        $this->assertNotEmpty($obj['created']);

        // Assert that logger  has not written keys with no values
        foreach ($missingKeys as $key) {
            $this->assertArrayNotHasKey($key, $obj);
        }
    }

    private function partialLogDataProvider(): array
    {
        return [
            [
                // Keys to add
                [
                    'level'   => Domain\Log::LOG_LEVEL_INFO,
                    'message' => 'message-asdf',
                    'origin'  => self::LOG_CHANNEL,
                ],
                // Missing Keys
                [
                    'channel_id',
                    'client_id',
                    'attributes',
                    'ip',
                    'method',
                    'metric',
                    'remote_addr',
                    'request_path',
                    'source_id',
                    'tags',
                    'trace',
                    'user_id',
                ]
            ],
            [
                // Keys to add
                [
                    'level'   => Domain\Log::LOG_LEVEL_INFO,
                    'message' => 'message-asdf',
                    'origin'  => self::LOG_CHANNEL,
                    'log_to_es' => true,
                ],
                // Missing Keys
                [
                    'channel_id',
                    'client_id',
                    'attributes',
                    'ip',
                    'method',
                    'metric',
                    'remote_addr',
                    'request_path',
                    'source_id',
                    'tags',
                    'trace',
                    'user_id',
                ]
            ],
            [
                // Keys to add
                [
                    'level'   => Domain\Log::LOG_LEVEL_INFO,
                    'message' => 'message-asdf',
                    'origin'  => self::LOG_CHANNEL,
                    'channel_id' => 20,
                    'client_id' => 21,
                    'tags' => [
                        'tag-1',
                        'tag-2',
                        'tag-3',
                    ],
                ],
                // Missing Keys
                [
                    'attributes',
                    'ip',
                    'method',
                    'metric',
                    'remote_addr',
                    'request_path',
                    'source_id',
                    'trace',
                    'user_id',
                ]
            ],
        ];
    }

    public function testLogComplex(): void
    {
        // test writing logs to file
        $loader = new LoaderArray([
            'LOG_CHANNEL'      => 'Logger',
            'LOG_FS_DIR'       => sprintf('%s/output/', __DIR__),
            'LOG_FS_ENABLED'   => 'true',
            'LOG_FS_FILE_NAME' => 'system.log'
        ]);
        Env::set($loader);

        // clean test file
        $this->resetLogs();

        Custom::log([
            'channel_id'   => 1,
            'client_id'    => 21,
            'attributes'   => [
                'key1' => 'value1',
                'key2' => 'value2'
            ],
            'created'      => Date::getDateString(),
            'ip'           => 'ip',
            'log_to_es'    => true,
            'level'        => Domain\Log::LOG_LEVEL_INFO,
            'message'      => 'message',
            'method'       => 'method',
            'metric'       => 10,
            'origin'       => 'origin',
            'remote_addr'  => 'remote_addr',
            'request_path' => 'request_path',
            'source_id'    => 57,
            'tags'         => ['tags'],
            'trace'        => ['trace'],
            'user_id'      => 1,
        ]);

        $parts = $this->getLogs();

        // 4 lines, one is space at end
        $this->assertCount(2, $parts);
        $this->assertEquals('', $parts[1]);
        for ($i = 0; $i < 1; $i++) {
            $obj = json_decode($parts[0], true);
            $this->assertEquals(1, $obj['channel_id']);
            $this->assertEquals(21, $obj['client_id']);
            $this->assertArrayNotHasKey('attributes', $obj);
            $this->assertArrayHasKey('key1', $obj);
            $this->assertArrayHasKey('key2', $obj);
            $this->assertEquals('value1', $obj['key1']);
            $this->assertEquals('value2', $obj['key2']);
            $this->assertEquals('ip', $obj['ip']);
            $this->assertTrue($obj['log_to_es']);
            $this->assertEquals(Domain\Log::LOG_LEVEL_INFO, $obj['level']);
            $this->assertEquals('message', $obj['message']);
            $this->assertEquals('method', $obj['method']);
            $this->assertEquals(10, $obj['metric']);
            $this->assertEquals('origin', $obj['origin']);
            $this->assertEquals('remote_addr', $obj['remote_addr']);
            $this->assertEquals('request_path', $obj['request_path']);
            $this->assertEquals(57, $obj['source_id']);
            $this->assertArrayHasKey('trace', $obj);
            $this->assertArrayHasKey('tags', $obj);
            $this->assertNotEmpty($obj['created']);
            $this->assertEquals(1, $obj['user_id']);
        }
    }
}
