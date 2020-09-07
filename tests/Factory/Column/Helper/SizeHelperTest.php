<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column\Helper;


use BronOS\PhpSqlDiscovery\Factory\Column\Helper\SizeHelperTrait;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class SizeHelperTest extends BaseTestCase
{
    public function testParseSize()
    {
        $helper = new class() {
            use SizeHelperTrait;
            public function test(string $columnType): int
            {
                return $this->parseSize($columnType);
            }
        };

        $this->assertEquals(11, $helper->test('int(11)'));
    }
}
