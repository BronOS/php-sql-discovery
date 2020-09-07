<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\MediumTextColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\MediumTextColumnInterface;

class MediumTextColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new MediumTextColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(15, $rows);

        /** @var MediumTextColumnInterface $clm */
        $clm = $factory->fromRow($rows[15]);

        $this->assertInstanceOf(MediumTextColumnInterface::class, $clm);

        $this->assertEquals('MEDIUMTEXT', $clm->getType());
        $this->assertEquals('t_mediumtext', $clm->getName());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertEquals('latin1', $clm->getCharset());
        $this->assertEquals('latin1_swedish_ci', $clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertFalse($clm->isBinary());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
