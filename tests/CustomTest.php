<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use Stock2Shop\Environment\Env;
use Stock2Shop\Environment\LoaderArray;
use Stock2Shop\Logger\ChannelProductsFail;
use Stock2Shop\Logger\Domain;
use Stock2Shop\Logger\Custom;
use Stock2Shop\Share\Utils\Date;

class CustomTest extends Base
{
    public function testLog()
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

        $log = new Domain\Log([
            'channel_id'   => 1,
            'client_id'    => 21,
            'attributes'   => [
                [
                    'key1' => 'value1'
                ],
                [
                    'key2' => 'value2'
                ]
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
        Custom::log($log);

        $parts = $this->getLogs();

        // 4 lines, one is space at end
        $this->assertCount(2, $parts);
        $this->assertEquals('', $parts[1]);
        for ($i = 0; $i < 1; $i++) {
            $obj = json_decode($parts[0], true);
            $this->assertEquals(1, $obj['channel_id']);
            $this->assertEquals(21, $obj['client_id']);
            $this->assertCount(2, $obj['attributes']);
            foreach ($obj['attributes'] as $index => $attribute) {
                $this->assertEquals(
                    sprintf("value%d", $index + 1),
                    $attribute[sprintf("key%d", $index + 1)]
                );
            }
            $this->assertNotEmpty($obj['created']);
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
            $this->assertEquals(['tags'], $obj['tags']);
            $this->assertEquals(['trace'], $obj['trace']);
            $this->assertEquals(1, $obj['user_id']);
        }
    }
}
