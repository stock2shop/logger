<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use Exception;
use Stock2Shop\Environment\Env;
use Stock2Shop\Environment\LoaderArray;
use Stock2Shop\Logger\Domain;
use Stock2Shop\Logger\Exception;

class LogExceptionTest extends Base
{
    public const MESSAGE = 'test log';

    public function testSave()
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

        Exception::log(new Exception(self::MESSAGE));

        $parts = $this->getLogs();

        // 4 lines, one is space at end
        $this->assertCount(2, $parts);
        $this->assertEquals('', $parts[1]);
        for ($i = 0; $i < 3; $i++) {
            $obj = json_decode($parts[0], true);
            $this->assertEquals(Domain\log::LOG_LEVEL_ERROR, $obj['level']);
            $this->assertEquals(self::MESSAGE, $obj['message']);
            $this->assertEquals(0, $obj['client_id']);
            $this->assertNotEmpty($obj['trace']);
            $this->assertArrayNotHasKey('tags', $obj);
            $this->assertArrayHasKey('datetime', $obj);
        }
    }
}
