<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\VarCharColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\VarCharColumnInterface;

class VarCharColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new VarCharColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(20, $rows);

        /** @var VarCharColumnInterface $clm */
        $clm = $factory->fromRow($rows[20]);

        $this->assertInstanceOf(VarCharColumnInterface::class, $clm);

        $this->assertEquals('VARCHAR', $clm->getType());
        $this->assertEquals('t_varchar', $clm->getName());
        $this->assertEquals(222, $clm->getSize());
        $this->assertEquals("ddd'sss", $clm->getDefault());
        $this->assertEquals('latin1', $clm->getCharset());
        $this->assertEquals('latin1_swedish_ci', $clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isNullable());
        $this->assertFalse($clm->isDefaultNull());
    }
}
