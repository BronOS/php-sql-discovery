<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\TimeColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\DateTime\TimeColumnInterface;

class TimeColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new TimeColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(24, $rows);

        /** @var TimeColumnInterface $clm */
        $clm = $factory->fromRow($rows[24]);

        $this->assertInstanceOf(TimeColumnInterface::class, $clm);

        $this->assertEquals('TIME', $clm->getType());
        $this->assertEquals('t_time', $clm->getName());
        $this->assertFalse($clm->isDefaultTimestamp());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
        $this->assertEquals('NULL', $clm->getDefault());
    }
}
