<?php

namespace BronOS\PhpSqlDiscovery\Tests\Factory;


use BronOS\PhpSqlDiscovery\Factory\IndexFactory;
use BronOS\PhpSqlDiscovery\Repository\IndexRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;
use BronOS\PhpSqlSchema\Index\KeyInterface;
use BronOS\PhpSqlSchema\Index\PrimaryKeyInterface;
use BronOS\PhpSqlSchema\Index\UniqueKeyInterface;

class IndexFactoryTest extends BaseTestCase
{
    public function testFromRows()
    {
        $repo = new IndexRepository($this->getPdo());
        $factory = new IndexFactory();

        $rows = $repo->findAll('post');

        $this->assertCount(5, $rows);

        $indexes = $factory->fromRows($rows);

        $this->assertCount(4, $indexes);

        $this->assertInstanceOf(PrimaryKeyInterface::class, $indexes[0]);
        $this->assertEquals(['id'], $indexes[0]->getFields());

        $this->assertInstanceOf(UniqueKeyInterface::class, $indexes[1]);
        $this->assertEquals('unq_1', $indexes[1]->getName());
        $this->assertEquals(['unq_1', 'unq_2'], $indexes[1]->getFields());

        $this->assertInstanceOf(KeyInterface::class, $indexes[2]);
        $this->assertEquals('blog_id', $indexes[2]->getName());
        $this->assertEquals(['blog_id'], $indexes[2]->getFields());

        $this->assertInstanceOf(KeyInterface::class, $indexes[3]);
        $this->assertEquals('keywords', $indexes[3]->getName());
        $this->assertEquals(['keywords'], $indexes[3]->getFields());
    }
}
