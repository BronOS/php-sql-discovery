<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\BigIntColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\BigIntColumnInterface;

class BigIntColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new BigIntColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(1, $rows);

        /** @var BigIntColumnInterface $clm */
        $clm = $factory->fromRow($rows[1]);

        $this->assertInstanceOf(BigIntColumnInterface::class, $clm);

        $this->assertEquals('BIGINT', $clm->getType());
        $this->assertEquals('t_bigint', $clm->getName());
        $this->assertEquals(20, $clm->getSize());
        $this->assertEquals('100', $clm->getDefault());
        $this->assertEquals('type bigint', $clm->getComment());
        $this->assertFalse($clm->isUnsigned());
        $this->assertFalse($clm->isAutoincrement());
        $this->assertFalse($clm->isZerofill());
        $this->assertFalse($clm->isNullable());
        $this->assertFalse($clm->isDefaultNull());
    }
}
