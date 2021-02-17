<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\TimestampColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\DateTime\TimestampColumnInterface;

class TimestampColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new TimestampColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(25, $rows);

        /** @var TimestampColumnInterface $clm */
        $clm = $factory->fromRow($rows[25]);

        $this->assertInstanceOf(TimestampColumnInterface::class, $clm);

        $this->assertEquals('TIMESTAMP', $clm->getType());
        $this->assertEquals('t_timestamp', $clm->getName());
        $this->assertTrue($clm->isDefaultTimestamp());
        $this->assertTrue($clm->isOnUpdateTimestamp());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isNullable());
        $this->assertFalse($clm->isDefaultNull());
        $this->assertEquals('CURRENT_TIMESTAMP', $clm->getDefault());
    }
}
