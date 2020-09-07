<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\TinyBlobColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\TinyBlobColumnInterface;

class TinyBlobColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new TinyBlobColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(17, $rows);

        /** @var TinyBlobColumnInterface $clm */
        $clm = $factory->fromRow($rows[17]);

        $this->assertInstanceOf(TinyBlobColumnInterface::class, $clm);

        $this->assertEquals('TINYBLOB', $clm->getType());
        $this->assertEquals('t_tinyblob', $clm->getName());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getCharset());
        $this->assertNull($clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
