<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\SetColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\SetColumnInterface;

class SetColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new SetColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(22, $rows);

        /** @var SetColumnInterface $clm */
        $clm = $factory->fromRow($rows[22]);

        $this->assertInstanceOf(SetColumnInterface::class, $clm);

        $this->assertEquals('SET', $clm->getType());
        $this->assertEquals('t_set', $clm->getName());
        $this->assertEquals(['x', 'y', 'z'], $clm->getOptions());
        $this->assertEquals('x,y', $clm->getDefault());
        $this->assertEquals(['x', 'y'], $clm->getDefaultList());
        $this->assertEquals('latin1', $clm->getCharset());
        $this->assertEquals('latin1_swedish_ci', $clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isNullable());
        $this->assertFalse($clm->isDefaultNull());
    }
}
