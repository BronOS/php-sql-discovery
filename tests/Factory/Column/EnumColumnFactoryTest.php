<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\EnumColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\EnumColumnInterface;

class EnumColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new EnumColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(21, $rows);

        /** @var EnumColumnInterface $clm */
        $clm = $factory->fromRow($rows[21]);

        $this->assertInstanceOf(EnumColumnInterface::class, $clm);

        $this->assertEquals('ENUM', $clm->getType());
        $this->assertEquals('t_enum', $clm->getName());
        $this->assertEquals(['a', 'b', 'c'], $clm->getOptions());
        $this->assertEquals('a', $clm->getDefault());
        $this->assertEquals('latin1', $clm->getCharset());
        $this->assertEquals('latin1_swedish_ci', $clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isNullable());
        $this->assertFalse($clm->isDefaultNull());
    }
}
