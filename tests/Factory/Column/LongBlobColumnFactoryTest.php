<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\LongBlobColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\LongBlobColumnInterface;

class LongBlobColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new LongBlobColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(12, $rows);

        /** @var LongBlobColumnInterface $clm */
        $clm = $factory->fromRow($rows[12]);

        $this->assertInstanceOf(LongBlobColumnInterface::class, $clm);

        $this->assertEquals('LONGBLOB', $clm->getType());
        $this->assertEquals('t_longblob', $clm->getName());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getCharset());
        $this->assertNull($clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
