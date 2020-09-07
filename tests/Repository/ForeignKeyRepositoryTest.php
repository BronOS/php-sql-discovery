<?php

namespace BronOS\PhpSqlDiscovery\Tests\Repository;


use BronOS\PhpSqlDiscovery\Repository\ForeignKeyRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class ForeignKeyRepositoryTest extends BaseTestCase
{
    public function testFindAll()
    {
        $repo = new ForeignKeyRepository($this->getPdo());
        $rows = $repo->findAll('post');

        $this->assertCount(1, $rows);
    }
}
