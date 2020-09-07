<?php

namespace BronOS\PhpSqlDiscovery\Tests;


use BronOS\PhpSqlDiscovery\Factory\DefaultColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\ForeignKeyFactory;
use BronOS\PhpSqlDiscovery\Factory\IndexFactory;
use BronOS\PhpSqlDiscovery\Factory\TableFactory;
use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Repository\ForeignKeyRepository;
use BronOS\PhpSqlDiscovery\Repository\IndexRepository;
use BronOS\PhpSqlDiscovery\Repository\TableRepository;
use BronOS\PhpSqlDiscovery\SQLColumnScanner;
use BronOS\PhpSqlDiscovery\SQLIndexScanner;
use BronOS\PhpSqlDiscovery\SQLRelationScanner;
use BronOS\PhpSqlDiscovery\SQLTableScanner;
use BronOS\PhpSqlSchema\SQLTableSchemaInterface;

class SQLTableScannerTest extends BaseTestCase
{
    public function testFindAll()
    {
        $indexRepo = new IndexRepository($this->getPdo());
        $indexFactory = new IndexFactory();
        $indexScanner = new SQLIndexScanner($indexRepo, $indexFactory);

        $relRepo = new ForeignKeyRepository($this->getPdo());
        $relFactory = new ForeignKeyFactory();
        $relScanner = new SQLRelationScanner($relRepo, $relFactory);

        $colRepo = new ColumnRepository($this->getPdo());
        $colFactory = new DefaultColumnFactory();
        $colScanner = new SQLColumnScanner($colRepo, $colFactory);

        $repo = new TableRepository($this->getPdo());
        $factory = new TableFactory();
        $scanner = new SQLTableScanner($repo, $factory, $indexScanner, $relScanner, $colScanner);

        $table = $scanner->scan('post');

        $this->assertInstanceOf(SQLTableSchemaInterface::class, $table);
        $this->assertEquals('post', $table->getName());
        $this->assertEquals('InnoDB', $table->getEngine());
        $this->assertEquals('latin1', $table->getDefaultCharset());
        $this->assertCount(9, $table->getColumns());
        $this->assertCount(4, $table->getIndexes());
        $this->assertCount(1, $table->getRelations());
    }
}
