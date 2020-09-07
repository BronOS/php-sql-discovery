<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\DecimalColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\DecimalColumnInterface;

class DecimalColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new DecimalColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(6, $rows);

        /** @var DecimalColumnInterface $clm */
        $clm = $factory->fromRow($rows[6]);

        $this->assertInstanceOf(DecimalColumnInterface::class, $clm);

        $this->assertEquals('DECIMAL', $clm->getType());
        $this->assertEquals('t_decimal', $clm->getName());
        $this->assertEquals(10, $clm->getPrecision());
        $this->assertEquals(2, $clm->getScale());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
