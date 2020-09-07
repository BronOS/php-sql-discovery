<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory\Column;


use BronOS\PhpSqlDiscovery\Factory\Column\MediumBlobColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Column\String\MediumBlobColumnInterface;

class MediumBlobColumnFactoryTest extends BaseTestCase
{
    public function testFromRow()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new MediumBlobColumnFactory();

        $rows = $repo->findAll('types');

        $this->assertArrayHasKey(18, $rows);

        /** @var MediumBlobColumnInterface $clm */
        $clm = $factory->fromRow($rows[18]);

        $this->assertInstanceOf(MediumBlobColumnInterface::class, $clm);

        $this->assertEquals('MEDIUMBLOB', $clm->getType());
        $this->assertEquals('t_mediumblob', $clm->getName());
        $this->assertEquals('NULL', $clm->getDefault());
        $this->assertNull($clm->getCharset());
        $this->assertNull($clm->getCollate());
        $this->assertNull($clm->getComment());
        $this->assertTrue($clm->isNullable());
        $this->assertTrue($clm->isDefaultNull());
    }
}
