<?php

namespace BronOS\PhpSqlDiscovery\Tests;


use BronOS\PhpSqlDiscovery\Factory\DefaultColumnFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\SQLColumnScanner;
use BronOS\PhpSqlSchema\Column\ColumnInterface;

class SQLColumnScannerTest extends BaseTestCase
{
    public function testFindAll()
    {
        $repo = new ColumnRepository($this->getPdo());
        $factory = new DefaultColumnFactory();
        $scanner = new SQLColumnScanner($repo, $factory);

        $columns = $scanner->scan('post');

        $this->assertCount(9, $columns);
        $this->assertInstanceOf(ColumnInterface::class, $columns[0]);
    }
}
