<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use Stock2Shop\Logger\Handler\HandlerFile;
use Stock2Shop\Logger\LogChannelProductsFail;
use Stock2Shop\Share\DTO;

class LogChannelProductsFailTest extends Base
{
    public function testSave()
    {
        // clean test file
        $this->resetLogs(__DIR__ . '/output/system.log');

        $client_id = 21;
        $channel_id = 57;
        $count = 2;

        $handler = new HandlerFile(__DIR__ . '/output/system.log');
        $log = new LogChannelProductsFail($handler);
        $log->write($channel_id, $client_id, $count);


        $parts = $this->getLogs(__DIR__ . '/output/system.log');

        // 4 lines, one is space at end
        $this->assertCount(2, $parts);
        $this->assertEquals('', $parts[1]);
        for ($i=0; $i<1; $i++) {
            $obj = json_decode($parts[0], true);
            $this->assertEquals(DTO\Log::LOG_LEVEL_ERROR, $obj['level']);
            $this->assertEquals(LogChannelProductsFail::MESSAGE, $obj['message']);
            $this->assertEquals(2, $obj['metric']);
            $this->assertEquals(21, $obj['client_id']);
            $this->assertEquals(57, $obj['channel_id']);
            $this->assertEquals(LogChannelProductsFail::TAG, $obj['tags'][0]);
            $this->assertEmpty($obj['trace']);
        }
    }

}
