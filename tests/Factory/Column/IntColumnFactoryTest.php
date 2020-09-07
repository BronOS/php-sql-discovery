<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\IntColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\IntColumnInterface;

class IntColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new IntColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(0, $rows);

        /** @var IntColumnInterface $clm */
        $clm = $factory->fromRow($rows[0]);

        $this->assertInstanceOf(IntColumnInterface::class, $clm);

        $this->assertEquals('INT', $clm->getType());
        $this->assertEquals('t_int', $clm->getName());
        $this->assertEquals(11, $clm->getSize());
        $this->assertNull($clm->getDefault());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isUnsigned());
        $this->assertTrue($clm->isAutoincrement());
        $this->assertFalse($clm->isZerofill());
        $this->assertFalse($clm->isNullable());
        $this->assertFalse($clm->isDefaultNull());
    }
}
