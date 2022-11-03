<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use Stock2Shop\Environment\LoaderArray;
use Stock2Shop\Environment\Env;
use Stock2Shop\Logger\Log;
use Stock2Shop\Logger\LogChannelProductsSuccess;
use Stock2Shop\Share\DTO;

class LogChannelProductsSuccessTest extends Base
{
    public function testSave()
    {
        // test writing logs to file
        $loader = new LoaderArray([
            'LOG_CHANNEL'      => 'Share',
            'LOG_FS_DIR'       => sprintf('%s/../../output/', __DIR__),
            'LOG_FS_ENABLED'   => 'true',
            'LOG_FS_FILE_NAME' => 'system.log'
        ]);
        Env::set($loader);

        // clean test file
        $this->resetLogs();

        $p   = DTO\ChannelProduct::createArray([
            [
                'client_id'  => 1,
                'channel_id' => 2,
            ],
            [
                'client_id'  => 1,
                'channel_id' => 2,
            ]
        ]);
        $log = new LogChannelProductsSuccess($p);
        $log->save();

        $parts = $this->getLogs();

        // 4 lines, one is space at end
        $this->assertCount(2, $parts);
        $this->assertEquals('', $parts[1]);
        for ($i = 0; $i < 1; $i++) {
            $obj = json_decode($parts[0], true);
            $this->assertEquals(Log::LOG_LEVEL_INFO, $obj['level']);
            $this->assertEquals(LogChannelProductsSuccess::MESSAGE, $obj['message']);
            $this->assertEquals(2, $obj['metric']);
            $this->assertEquals(1, $obj['client_id']);
            $this->assertEquals(2, $obj['channel_id']);
            $this->assertEquals(LogChannelProductsSuccess::TAG, $obj['tags'][0]);
            $this->assertArrayNotHasKey('trace', $obj);
            $this->assertArrayHasKey('datetime', $obj);
        }
    }

}
