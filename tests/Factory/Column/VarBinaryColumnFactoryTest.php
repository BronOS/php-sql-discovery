<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\VarBinaryColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\VarBinaryColumnInterface;

class VarBinaryColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new VarBinaryColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(19, $rows);

        /** @var VarBinaryColumnInterface $clm */
        $clm = $factory->fromRow($rows[19]);

        $this->assertInstanceOf(VarBinaryColumnInterface::class, $clm);

        $this->assertEquals('VARBINARY', $clm->getType());
        $this->assertEquals('t_varbinary', $clm->getName());
        $this->assertEquals(42, $clm->getSize());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getCharset());
        $this->assertNull($clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
