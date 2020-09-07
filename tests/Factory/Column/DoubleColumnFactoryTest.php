<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\DoubleColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\DoubleColumnInterface;

class DoubleColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new DoubleColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(7, $rows);

        /** @var DoubleColumnInterface $clm */
        $clm = $factory->fromRow($rows[7]);

        $this->assertInstanceOf(DoubleColumnInterface::class, $clm);

        $this->assertEquals('DOUBLE', $clm->getType());
        $this->assertEquals('t_double', $clm->getName());
        $this->assertEquals(12, $clm->getPrecision());
        $this->assertEquals(4, $clm->getScale());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
