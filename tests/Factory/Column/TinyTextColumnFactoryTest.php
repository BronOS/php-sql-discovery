<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\TinyTextColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\TinyTextColumnInterface;

class TinyTextColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new TinyTextColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(14, $rows);

        /** @var TinyTextColumnInterface $clm */
        $clm = $factory->fromRow($rows[14]);

        $this->assertInstanceOf(TinyTextColumnInterface::class, $clm);

        $this->assertEquals('TINYTEXT', $clm->getType());
        $this->assertEquals('t_tinytext', $clm->getName());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertEquals('latin1', $clm->getCharset());
        $this->assertEquals('latin1_swedish_ci', $clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isBinary());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
