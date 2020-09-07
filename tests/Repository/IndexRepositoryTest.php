<?php

namespace BronOS\PhpSqlDiscovery\Tests\Repository;


use BronOS\PhpSqlDiscovery\Repository\IndexRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class IndexRepositoryTest extends BaseTestCase
{
    public function testFindAll()
    {
        $repo = new IndexRepository($this->getPdo());
        $rows = $repo->findAll('post');

        $this->assertCount(5, $rows);

        $idRow = $rows[0];

        $this->assertArrayHasKey('Table', $idRow);
        $this->assertArrayHasKey('Non_unique', $idRow);
        $this->assertArrayHasKey('Key_name', $idRow);
        $this->assertArrayHasKey('Seq_in_index', $idRow);
        $this->assertArrayHasKey('Column_name', $idRow);
        $this->assertArrayHasKey('Collation', $idRow);
        $this->assertArrayHasKey('Sub_part', $idRow);
        $this->assertArrayHasKey('Packed', $idRow);
        $this->assertArrayHasKey('Null', $idRow);
        $this->assertArrayHasKey('Index_type', $idRow);
        $this->assertArrayHasKey('Comment', $idRow);
        $this->assertArrayHasKey('Index_comment', $idRow);
    }
}
