<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\DateTimeColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\DateTime\DateTimeColumnInterface;

class DateTimeColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new DateTimeColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(26, $rows);

        /** @var DateTimeColumnInterface $clm */
        $clm = $factory->fromRow($rows[26]);

        $this->assertInstanceOf(DateTimeColumnInterface::class, $clm);

        $this->assertEquals('DATETIME', $clm->getType());
        $this->assertEquals('t_datetime', $clm->getName());
        $this->assertTrue($clm->isDefaultTimestamp());
        $this->assertTrue($clm->isOnUpdateTimestamp());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertFalse($clm->isDefaultNull());
        $this->assertEquals('current_timestamp()', $clm->getDefault());
    }
}
