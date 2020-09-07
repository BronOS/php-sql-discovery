<?php

/**
 * Php Sql Discovery
 *
 * MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace BronOS\PhpSqlDiscovery;


use BronOS\PhpSqlDiscovery\Exception\PhpSqlDiscoveryException;
use BronOS\PhpSqlDiscovery\Factory\TableFactoryInterface;
use BronOS\PhpSqlDiscovery\Repository\TableRepositoryInterface;
use BronOS\PhpSqlSchema\Exception\DuplicateColumnException;
use BronOS\PhpSqlSchema\Exception\DuplicateIndexException;
use BronOS\PhpSqlSchema\Exception\DuplicateRelationException;
use BronOS\PhpSqlSchema\Exception\SQLTableSchemaDeclarationException;
use BronOS\PhpSqlSchema\SQLTableSchemaInterface;

/**
 * Table scanner.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class SQLTableScanner implements SQLTableScannerInterface
{
    private TableRepositoryInterface $repository;
    private TableFactoryInterface $factory;
    private SQLIndexScannerInterface $indexScanner;
    private SQLRelationScannerInterface $relationScanner;
    private SQLColumnScannerInterface $columnScanner;

    /**
     * SQLTableScanner constructor.
     *
     * @param TableRepositoryInterface $repository
     * @param TableFactoryInterface $factory
     * @param SQLIndexScannerInterface $indexScanner
     * @param SQLRelationScannerInterface $relationScanner
     * @param SQLColumnScannerInterface $columnScanner
     */
    public function __construct(
        TableRepositoryInterface $repository,
        TableFactoryInterface $factory,
        SQLIndexScannerInterface $indexScanner,
        SQLRelationScannerInterface $relationScanner,
        SQLColumnScannerInterface $columnScanner
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->indexScanner = $indexScanner;
        $this->relationScanner = $relationScanner;
        $this->columnScanner = $columnScanner;
    }

    /**
     * Scans database table meta data and returns SQLTableSchema object as a result.
     *
     * @param string $tableName
     *
     * @return SQLTableSchemaInterface
     *
     * @throws PhpSqlDiscoveryException
     * @throws DuplicateColumnException
     * @throws DuplicateIndexException
     * @throws DuplicateRelationException
     * @throws SQLTableSchemaDeclarationException
     */
    public function scan(string $tableName): SQLTableSchemaInterface
    {
        return $this->factory->make(
            $this->repository->findInfo($tableName),
            $this->columnScanner->scan($tableName),
            $this->indexScanner->scan($tableName),
            $this->relationScanner->scan($tableName)
        );
    }
}