<?php

declare(strict_types=1);

namespace Stock2Shop\Tests\Logger;

use Stock2Shop\Logger\Domain;

class LogTest extends Base
{
    /** @dataProvider flattenDataProvider */
    public function testFlatten(string $name, array $data): void
    {
        $log = new Domain\Log($data);
        $this->assertInstanceOf(Domain\Log::class, $log);

        $arr = $log->flatten();
        $this->assertArrayHasKey('tags', $arr);
        $this->assertArrayHasKey('trace', $arr);

        // check that date and provided properties have been set
        $this->assertNotEmpty($arr['created']);
        $this->assertEquals(Domain\Log::LOG_LEVEL_INFO, $arr['level']);
        $this->assertEquals('message', $arr['message']);
        $this->assertEquals('origin', $arr['origin']);

        // check that attribute has been flattened
        $this->assertArrayHasKey('key1', $arr);
        $this->assertEquals('value1', $arr['key1']);

        if ($name == 'complex') {
            $this->assertArrayHasKey('key1', $arr);
            $this->assertEquals('value1', $arr['key1']);
            $this->assertArrayHasKey('key2', $arr);
            $this->assertEquals('value2', $arr['key2']);
            $this->assertArrayHasKey('key3', $arr);
            $this->assertEquals('value3', $arr['key3']);
        }
    }

    public function flattenDataProvider(): \Generator
    {
        yield [
            'name' => 'simple',
            [
                'level'      => Domain\Log::LOG_LEVEL_INFO,
                'message'    => 'message',
                'origin'     => 'origin',
                'attributes' => [
                    'key1' => 'value1'
                ],
            ]
        ];
        yield [
            'name' => 'complex',
            [
                'level'      => Domain\Log::LOG_LEVEL_INFO,
                'message'    => 'message',
                'origin'     => 'origin',
                'attributes' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                    'key3' => 'value3',
                ],
            ]
        ];
    }
}
