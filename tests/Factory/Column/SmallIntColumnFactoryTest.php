<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\SmallIntColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\SmallIntColumnInterface;

class SmallIntColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new SmallIntColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(4, $rows);

        /** @var SmallIntColumnInterface $clm */
        $clm = $factory->fromRow($rows[4]);

        $this->assertInstanceOf(SmallIntColumnInterface::class, $clm);

        $this->assertEquals('SMALLINT', $clm->getType());
        $this->assertEquals('t_smallint', $clm->getName());
        $this->assertEquals(6, $clm->getSize());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isUnsigned());
        $this->assertFalse($clm->isAutoincrement());
        $this->assertFalse($clm->isZerofill());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
