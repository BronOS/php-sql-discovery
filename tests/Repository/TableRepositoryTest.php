<?php

namespace BronOS\PhpSqlDiscovery\Tests\Repository;


use BronOS\PhpSqlDiscovery\Repository\TableRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class TableRepositoryTest extends BaseTestCase
{
    public function testFind()
    {
        $repo = new TableRepository($this->getPdo());
        $row = $repo->findInfo('blog');

        $this->assertArrayHasKey('ENGINE', $row);
        $this->assertArrayHasKey('TABLE_COLLATION', $row);
        $this->assertArrayHasKey('CHARACTER_SET_NAME', $row);
    }

    public function testFindAll()
    {
        $repo = new TableRepository($this->getPdo());

        $rows = $repo->findInfoAll();
        $this->assertCount(3, $rows);

        $rows = $repo->findInfoAll(['post', 'types']);
        $this->assertCount(1, $rows);

        $row = $rows[0];

        $this->assertArrayHasKey('ENGINE', $row);
        $this->assertArrayHasKey('TABLE_COLLATION', $row);
        $this->assertArrayHasKey('CHARACTER_SET_NAME', $row);
    }
}
