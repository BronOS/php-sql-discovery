<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column\Helper;


use BronOS\PhpSqlDiscovery\Factory\Column\Helper\UnsignedHelperTrait;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class UnsignedHelperTest extends BaseTestCase
{
    public function testIsUnsigned()
    {
        $helper = new class() {
            use UnsignedHelperTrait;
            public function test(string $columnType): bool
            {
                return $this->isUnsigned($columnType);
            }
        };

        $this->assertTrue($helper->test('int(11) unsigned'));
        $this->assertFalse($helper->test('int(11)'));
    }
}
