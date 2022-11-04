<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use InvalidArgumentException;
use Monolog\Handler\StreamHandler;
use Stock2Shop\Environment\Env;
use Stock2Shop\Environment\LoaderArray;
use Stock2Shop\Logger\EnvKey;
use Stock2Shop\Logger\Logger;

class LoggerTest extends Base
{
    public function testInvalidHandler()
    {
        $this->expectException(InvalidArgumentException::class);
        $loader = new LoaderArray([
            EnvKey::LOG_CW_ENABLED => 'false',
            EnvKey::LOG_FS_ENABLED => 'false'
        ]);
        Env::set($loader);
        new Logger();
    }

    public function testSetOneHandler()
    {
        $loader = new LoaderArray([
            EnvKey::LOG_CW_ENABLED   => 'false',
            EnvKey::LOG_FS_ENABLED   => 'true',
            EnvKey::LOG_CHANNEL      => 'Share',
            EnvKey::LOG_FS_DIR       => sprintf('%s/output/', __DIR__),
            EnvKey::LOG_FS_FILE_NAME => 'system.log'
        ]);
        Env::set($loader);
        $logger   = new Logger();
        $handlers = $logger->getHandlers();
        $this->assertCount(1, $handlers);
        $this->assertInstanceOf(StreamHandler::class, $handlers[0]);
        $this->assertInstanceOf(\Monolog\Logger::class, $logger);
        $this->assertEquals(Env::get(EnvKey::LOG_CHANNEL), $logger->getName());
    }

    public function testSetMultipleHandlers()
    {
        $loader = new LoaderArray([
            // CWL handler configuration
            EnvKey::LOG_CW_ENABLED        => 'true',
            EnvKey::LOG_CW_KEY            => ' ',
            EnvKey::LOG_CW_SECRET         => ' ',
            EnvKey::LOG_CW_VERSION        => 'latest',
            EnvKey::LOG_CW_REGION         => 'eu-west-1',
            EnvKey::LOG_CW_GROUP_NAME     => '/Logger',
            EnvKey::LOG_CW_RETENTION_DAYS => '14',
            EnvKey::LOG_CW_BATCH_SIZE     => '10000',

            // FS handler configuration
            EnvKey::LOG_FS_ENABLED   => 'true',
            EnvKey::LOG_FS_DIR       => sprintf('%s/output/', __DIR__),
            EnvKey::LOG_FS_FILE_NAME => 'system.log',

            // logger name
            EnvKey::LOG_CHANNEL      => 'Share'
        ]);
        Env::set($loader);
        $logger   = new Logger();
        $handlers = $logger->getHandlers();
        $this->assertCount(2, $handlers);
    }
}
