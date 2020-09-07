<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\TextColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\TextColumnInterface;

class TextColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new TextColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(13, $rows);

        /** @var TextColumnInterface $clm */
        $clm = $factory->fromRow($rows[13]);

        $this->assertInstanceOf(TextColumnInterface::class, $clm);

        $this->assertEquals('TEXT', $clm->getType());
        $this->assertEquals('t_text', $clm->getName());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertEquals('latin1', $clm->getCharset());
        $this->assertEquals('latin1_bin', $clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isBinary());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
