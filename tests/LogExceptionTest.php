<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use Exception;
use Stock2Shop\Logger\Handler\HandlerFile;
use Stock2Shop\Logger\LogException;
use Stock2Shop\Share\DTO;

class LogExceptionTest extends Base
{
//    public const MESSAGE = 'test log';
//
//    public function testSave()
//    {
//        // clean test file
//        $this->resetLogs(__DIR__ . '/output/system.log');
//
//        $handler = new HandlerFile(__DIR__ . '/output/system.log');
//        $log = new LogException($handler, 'origin');
//        $log->write(new Exception(self::MESSAGE), 57, 21);
//
//        $parts = $this->getLogs(__DIR__ . '/output/system.log');
//
//        // 4 lines, one is space at end
//        $this->assertCount(2, $parts);
//        $this->assertEquals('', $parts[1]);
//        for ($i=0; $i<3; $i++) {
//            $obj = json_decode($parts[0], true);
//            $this->assertEquals(DTO\Log::LOG_LEVEL_ERROR, $obj['level']);
//            $this->assertEquals(self::MESSAGE, $obj['message']);
//            $this->assertEquals(21, $obj['client_id']);
//            $this->assertNotEmpty($obj['trace']);
//            $this->assertArrayNotHasKey('tags', $obj);
//            $this->assertArrayHasKey('datetime', $obj);
//        }
//    }
}
