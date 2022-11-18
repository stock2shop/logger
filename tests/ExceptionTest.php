<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use Exception as E;
use Stock2Shop\Environment\Env;
use Stock2Shop\Environment\LoaderArray;
use Stock2Shop\Logger\Domain;
use Stock2Shop\Logger\Exception;

class ExceptionTest extends Base
{
    public const MESSAGE = 'test log';

    public function testLogBasic(): void
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

        Exception::log(new E(self::MESSAGE));

        $parts = $this->getLogs();

        // 4 lines, one is space at end
        $this->assertCount(2, $parts);
        $this->assertEquals('', $parts[1]);
        for ($i = 0; $i < 3; $i++) {
            $obj = json_decode($parts[0], true);
            $this->assertEquals(Domain\Log::LOG_LEVEL_ERROR, $obj['level']);
            $this->assertEquals(self::MESSAGE, $obj['message']);
            $this->assertEquals(self::LOG_CHANNEL, $obj['origin']);
            $this->assertEquals(0, $obj['client_id']);
            $this->assertArrayHasKey('trace', $obj);
            $this->assertTrue($obj['log_to_es']);
            $this->assertNotEmpty($obj['created']);

            // Missing properties should not be logged
            $this->assertArrayNotHasKey('attributes', $obj);
            $this->assertArrayNotHasKey('ip', $obj);
            $this->assertArrayNotHasKey('method', $obj);
            $this->assertArrayNotHasKey('remote_addr', $obj);
            $this->assertArrayNotHasKey('request_path', $obj);
            $this->assertArrayNotHasKey('source_id', $obj);
            $this->assertArrayNotHasKey('user_id', $obj);
        }
    }

    /**
     * @dataProvider partialLogDataProvider
     * @param array<string, mixed> $keysToAdd
     * @param string[] $missingKeys
     */
    public function testLogComplex(array $keysToAdd, array $missingKeys): void
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

        $logContext = [];
        foreach ($keysToAdd as $k => $v) {
            $logContext[$k] = $v;
        }
        Exception::log(new E(self::MESSAGE), $logContext);

        $parts = $this->getLogs();

        // 4 lines, one is space at end
        $this->assertCount(2, $parts);
        $this->assertEquals('', $parts[1]);
        for ($i = 0; $i < 3; $i++) {
            $obj = json_decode($parts[0], true);
            $this->assertEquals(Domain\Log::LOG_LEVEL_ERROR, $obj['level']);
            $this->assertEquals(self::MESSAGE, $obj['message']);
            $this->assertEquals(self::LOG_CHANNEL, $obj['origin']);
            $this->assertEquals(0, $obj['client_id']);
            $this->assertArrayHasKey('trace', $obj);

            // Assert that keys provided have been written
            foreach ($keysToAdd as $key => $value) {
                $this->assertEquals($value, $obj[$key], sprintf("%s: %s", $key, $value));
            }

            // Assert that keys with default values have been written
            $this->assertEquals($keysToAdd['log_to_es'] ?? true, $obj['log_to_es']);
            $this->assertNotEmpty($obj['created']);

            // Assert that logger  has not written keys with no values
            foreach ($missingKeys as $key) {
                $this->assertArrayNotHasKey($key, $obj);
            }
        }
    }

    private function partialLogDataProvider(): array
    {
        return [
            [
                // Keys to add
                [
                    'remote_addr' => 'remote_addr-1',
                    'request_path' => 'request_path-1',
                    'source_id' => 57,
                ],
                // Missing Keys
                [
                    'channel_id',
                    'attributes',
                    'ip',
                    'method',
                    'metric',
                    'tags',
                    'user_id',
                ]
            ],
            [
                // Keys to add
                [
                    'remote_addr' => 'remote_addr-2',
                    'request_path' => 'request_path-2',
                    'source_id' => 57,
                    'log_to_es' => true,
                ],
                // Missing Keys
                [
                    'channel_id',
                    'attributes',
                    'ip',
                    'method',
                    'metric',
                    'tags',
                    'user_id',
                ]
            ],
            [
                // Keys to add
                [
                    'remote_addr' => 'remote_addr-3',
                    'request_path' => 'request_path-3',
                    'source_id' => 57,
                    'channel_id' => 20,
                ],
                // Missing Keys
                [
                    'attributes',
                    'ip',
                    'method',
                    'metric',
                    'user_id',
                ]
            ],
        ];
    }
}
