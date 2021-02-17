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

        $this->assertArrayHasKey('COLUMN_NAME', $idRow);
        $this->assertArrayHasKey('DATA_TYPE', $idRow);
        $this->assertArrayHasKey('COLUMN_TYPE', $idRow);
        $this->assertArrayHasKey('COLUMN_DEFAULT', $idRow);
        $this->assertArrayHasKey('IS_NULLABLE', $idRow);
        $this->assertArrayHasKey('COLUMN_COMMENT', $idRow);
        $this->assertArrayHasKey('EXTRA', $idRow);
        $this->assertArrayHasKey('CHARACTER_SET_NAME', $idRow);
        $this->assertArrayHasKey('COLLATION_NAME', $idRow);

        $this->assertEquals('id', $idRow['COLUMN_NAME']);
        $this->assertEquals('int', $idRow['DATA_TYPE']);
        $this->assertEquals('int(11) unsigned', $idRow['COLUMN_TYPE']);
        $this->assertNull($idRow['COLUMN_DEFAULT']);
        $this->assertEquals('NO', $idRow['IS_NULLABLE']);
        $this->assertEquals('', $idRow['COLUMN_COMMENT']);
        $this->assertEquals('auto_increment', $idRow['EXTRA']);
        $this->assertNull($idRow['CHARACTER_SET_NAME']);
        $this->assertNull($idRow['COLLATION_NAME']);
    }
}
