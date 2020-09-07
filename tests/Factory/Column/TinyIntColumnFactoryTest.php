<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\TinyIntColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\TinyIntColumnInterface;

class TinyIntColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new TinyIntColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(2, $rows);

        /** @var TinyIntColumnInterface $clm */
        $clm = $factory->fromRow($rows[2]);

        $this->assertInstanceOf(TinyIntColumnInterface::class, $clm);

        $this->assertEquals('TINYINT', $clm->getType());
        $this->assertEquals('t_tinyint', $clm->getName());
        $this->assertEquals(1, $clm->getSize());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isUnsigned());
        $this->assertFalse($clm->isAutoincrement());
        $this->assertFalse($clm->isZerofill());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
