<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column\Helper;


use BronOS\PhpSqlDiscovery\Factory\Column\Helper\FloatSizeHelperTrait;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class FloatSizeHelperTest extends BaseTestCase
{
    public function testParseSize()
    {
        $helper = new class() {
            use FloatSizeHelperTrait;
            public function test(string $columnType): array
            {
                return $this->parseSize($columnType);
            }
        };

        $this->assertEquals([10, 2], $helper->test('float(10,2)'));
        $this->assertEquals([10, 2], $helper->test('float( 10 ,   2 )'));
        $this->assertEquals([null, null], $helper->test('float'));
    }
}
