<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column\Helper;


use BronOS\PhpSqlDiscovery\Factory\Column\Helper\OptionsHelperTrait;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class OptionsHelperTest extends BaseTestCase
{
    public function testParseOptions()
    {
        $helper = new class() {
            use OptionsHelperTrait;
            public function test(string $columnType): array
            {
                return $this->parseOptions($columnType);
            }
        };

        $this->assertEquals(['a', 'b', 'c'], $helper->test("enum('a','b','c')"));
    }
}
