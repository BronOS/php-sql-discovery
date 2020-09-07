<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\BitColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\BitColumnInterface;

class BitColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new BitColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(8, $rows);

        /** @var BitColumnInterface $clm */
        $clm = $factory->fromRow($rows[8]);

        $this->assertInstanceOf(BitColumnInterface::class, $clm);

        $this->assertEquals('BIT', $clm->getType());
        $this->assertEquals('t_bit', $clm->getName());
        $this->assertEquals(1, $clm->getSize());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
