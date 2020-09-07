<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\LongTextColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\LongTextColumnInterface;

class LongTextColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new LongTextColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(16, $rows);

        /** @var LongTextColumnInterface $clm */
        $clm = $factory->fromRow($rows[16]);

        $this->assertInstanceOf(LongTextColumnInterface::class, $clm);

        $this->assertEquals('LONGTEXT', $clm->getType());
        $this->assertEquals('t_longtext', $clm->getName());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertEquals('latin1', $clm->getCharset());
        $this->assertEquals('latin1_swedish_ci', $clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isBinary());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
