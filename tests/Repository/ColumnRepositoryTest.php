<?php

namespace BronOS\PhpSqlDiscovery\Tests\Repository;


use BronOS\PhpSqlDiscovery\Repository\ColumnRepository;
use BronOS\PhpSqlDiscovery\Tests\BaseTestCase;

class ColumnRepositoryTest extends BaseTestCase
{
    public function testFindAll()
    {
        $repo = new ColumnRepository($this->getPdo());
        $rows = $repo->findAll('blog');

        $this->assertCount(2, $rows);

        $idRow = $rows[0];

        $this->assertArrayHasKey('column_name', $idRow);
        $this->assertArrayHasKey('data_type', $idRow);
        $this->assertArrayHasKey('column_type', $idRow);
        $this->assertArrayHasKey('column_default', $idRow);
        $this->assertArrayHasKey('is_nullable', $idRow);
        $this->assertArrayHasKey('column_comment', $idRow);
        $this->assertArrayHasKey('extra', $idRow);
        $this->assertArrayHasKey('character_set_name', $idRow);
        $this->assertArrayHasKey('collation_name', $idRow);

        $this->assertEquals('id', $idRow['column_name']);
        $this->assertEquals('int', $idRow['data_type']);
        $this->assertEquals('int(11) unsigned', $idRow['column_type']);
        $this->assertNull($idRow['column_default']);
        $this->assertEquals('NO', $idRow['is_nullable']);
        $this->assertEquals('', $idRow['column_comment']);
        $this->assertEquals('auto_increment', $idRow['extra']);
        $this->assertNull($idRow['character_set_name']);
        $this->assertNull($idRow['collation_name']);
    }
}
