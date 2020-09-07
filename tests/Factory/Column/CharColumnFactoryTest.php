<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\CharColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\CharColumnInterface;

class CharColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new CharColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(10, $rows);

        /** @var CharColumnInterface $clm */
        $clm = $factory->fromRow($rows[11]);

        $this->assertInstanceOf(CharColumnInterface::class, $clm);

        $this->assertEquals('CHAR', $clm->getType());
        $this->assertEquals('t_char', $clm->getName());
        $this->assertEquals(100, $clm->getSize());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertEquals('latin1', $clm->getCharset());
        $this->assertEquals('latin1_swedish_ci', $clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
