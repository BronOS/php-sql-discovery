<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\MediumIntColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\Numeric\MediumIntColumnInterface;

class MediumIntColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new MediumIntColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(3, $rows);

        /** @var MediumIntColumnInterface $clm */
        $clm = $factory->fromRow($rows[3]);

        $this->assertInstanceOf(MediumIntColumnInterface::class, $clm);

        $this->assertEquals('MEDIUMINT', $clm->getType());
        $this->assertEquals('t_mediumint', $clm->getName());
        $this->assertEquals(9, $clm->getSize());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isUnsigned());
        $this->assertFalse($clm->isAutoincrement());
        $this->assertFalse($clm->isZerofill());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
