<?php

namespace BronOS\PhpSqlDiscovery\Tests\Repository;


use BronOS\PhpSqlDiscovery\Repository\TableRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class TableRepositoryTest extends BaseTestCase
{
    public function testFindAll()
    {
        $repo = new TableRepository($this->getPdo());
        $row = $repo->findInfo('blog');

        $this->assertArrayHasKey('ENGINE', $row);
        $this->assertArrayHasKey('TABLE_COLLATION', $row);
        $this->assertArrayHasKey('CHARACTER_SET_NAME', $row);
    }
}
