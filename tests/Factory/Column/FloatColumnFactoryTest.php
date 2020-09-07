<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\FloatColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\FloatColumnInterface;

class FloatColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new FloatColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(5, $rows);

        /** @var FloatColumnInterface $clm */
        $clm = $factory->fromRow($rows[5]);

        $this->assertInstanceOf(FloatColumnInterface::class, $clm);

        $this->assertEquals('FLOAT', $clm->getType());
        $this->assertEquals('t_float', $clm->getName());
        $this->assertNull($clm->getPrecision());
        $this->assertNull($clm->getScale());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
