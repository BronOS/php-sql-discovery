<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\BlobColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\BlobColumnInterface;

class BlobColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new BlobColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(10, $rows);

        /** @var BlobColumnInterface $clm */
        $clm = $factory->fromRow($rows[10]);

        $this->assertInstanceOf(BlobColumnInterface::class, $clm);

        $this->assertEquals('BLOB', $clm->getType());
        $this->assertEquals('t_blob', $clm->getName());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getCharset());
        $this->assertNull($clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
