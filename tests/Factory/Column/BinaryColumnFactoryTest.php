<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\BinaryColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\BinaryColumnInterface;

class BinaryColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new BinaryColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(9, $rows);

        /** @var BinaryColumnInterface $clm */
        $clm = $factory->fromRow($rows[9]);

        $this->assertInstanceOf(BinaryColumnInterface::class, $clm);

        $this->assertEquals('BINARY', $clm->getType());
        $this->assertEquals('t_binary', $clm->getName());
        $this->assertEquals(1, $clm->getSize());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getCharset());
        $this->assertNull($clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
