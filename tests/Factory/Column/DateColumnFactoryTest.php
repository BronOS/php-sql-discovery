<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\DateColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\DateTime\DateColumnInterface;

class DateColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new DateColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(23, $rows);

        /** @var DateColumnInterface $clm */
        $clm = $factory->fromRow($rows[23]);

        $this->assertInstanceOf(DateColumnInterface::class, $clm);

        $this->assertEquals('DATE', $clm->getType());
        $this->assertEquals('t_date', $clm->getName());
        $this->assertTrue($clm->isDefaultTimestamp());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isNullable());
        $this->assertFalse($clm->isDefaultNull());
        $this->assertEquals('current_timestamp()', $clm->getDefault());
    }
}
