<?php

namespace BronOS\PhpSqlDiscovery\Tests;


use BronOS\PhpSqlDiscovery\Factory\ForeignKeyFactory;
use BronOS\PhpSqlDiscovery\Repository\ForeignKeyRepository;
use BronOS\PhpSqlDiscovery\SQLRelationScanner;
use BronOS\PhpSqlSchema\Relation\ForeignKeyInterface;

class SQLRelationScannerTest extends BaseTestCase
{
    public function testFindAll()
    {
        $repo = new ForeignKeyRepository($this->getPdo());
        $factory = new ForeignKeyFactory();
        $scanner = new SQLRelationScanner($repo, $factory);

        $relations = $scanner->scan('post');

        $this->assertCount(1, $relations);
        $this->assertInstanceOf(ForeignKeyInterface::class, $relations[0]);
    }
}
