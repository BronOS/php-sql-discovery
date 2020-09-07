<?php

namespace BronOS\PhpSqlDiscovery\Tests;


use BronOS\PhpSqlDiscovery\Factory\IndexFactory;
use BronOS\PhpSqlDiscovery\Repository\IndexRepository;
use BronOS\PhpSqlDiscovery\SQLIndexScanner;
use BronOS\PhpSqlSchema\Index\IndexInterface;

class SQLIndexScannerTest extends BaseTestCase
{
    public function testFindAll()
    {
        $repo = new IndexRepository($this->getPdo());
        $factory = new IndexFactory();
        $scanner = new SQLIndexScanner($repo, $factory);

        $indexes = $scanner->scan('post');

        $this->assertCount(4, $indexes);
        $this->assertInstanceOf(IndexInterface::class, $indexes[0]);
    }
}
