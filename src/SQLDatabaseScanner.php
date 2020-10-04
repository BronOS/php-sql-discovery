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
use BronOS\PhpSqlDiscovery\Factory\DatabaseFactoryInterface;
use BronOS\PhpSqlDiscovery\Repository\DefaultsRepositoryInterface;
use BronOS\PhpSqlSchema\Exception\DuplicateColumnException;
use BronOS\PhpSqlSchema\Exception\DuplicateIndexException;
use BronOS\PhpSqlSchema\Exception\DuplicateRelationException;
use BronOS\PhpSqlSchema\Exception\DuplicateTableException;
use BronOS\PhpSqlSchema\Exception\SQLTableSchemaDeclarationException;
use BronOS\PhpSqlSchema\SQLDatabaseSchemaInterface;
use BronOS\PhpSqlSchema\SQLTableSchemaInterface;

/**
 * Database scanner.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class SQLDatabaseScanner implements SQLDatabaseScannerInterface
{
    private SQLTableScannerInterface $tableScanner;
    private DefaultsRepositoryInterface $defaultsRepository;
    private DatabaseFactoryInterface $dbFactory;

    /**
     * SQLDatabaseScanner constructor.
     *
     * @param SQLTableScannerInterface $tableScanner
     * @param DefaultsRepositoryInterface $defaultsRepository
     * @param DatabaseFactoryInterface $dbFactory
     */
    public function __construct(
        SQLTableScannerInterface $tableScanner,
        DefaultsRepositoryInterface $defaultsRepository,
        DatabaseFactoryInterface $dbFactory
    ) {
        $this->tableScanner = $tableScanner;
        $this->defaultsRepository = $defaultsRepository;
        $this->dbFactory = $dbFactory;
    }

    /**
     * Scans database meta data and returns it as a SQLTableSchemaInterface object.
     *
     * @param array $tables
     *
     * @return SQLDatabaseSchemaInterface
     *
     * @throws DuplicateColumnException
     * @throws DuplicateIndexException
     * @throws DuplicateRelationException
     * @throws DuplicateTableException
     * @throws PhpSqlDiscoveryException
     * @throws SQLTableSchemaDeclarationException
     */
    public function scan(array $tables = []): SQLDatabaseSchemaInterface
    {
        return $this->dbFactory->make(
            $this->defaultsRepository->fetchDbName(),
            $this->getTables($tables),
            $this->defaultsRepository->findInfo()
        );
    }

    /**
     * @param string[] $tableNames
     *
     * @return SQLTableSchemaInterface[]
     *
     * @throws DuplicateColumnException
     * @throws DuplicateIndexException
     * @throws DuplicateRelationException
     * @throws PhpSqlDiscoveryException
     * @throws SQLTableSchemaDeclarationException
     */
    private function getTables(array $tableNames = []): array
    {
        if (count($tableNames) == 0) {
            return $this->tableScanner->scanAll();
        }

        $tables = [];
        foreach ($tableNames as $tableName) {
            $tables[] = $this->tableScanner->scan($tableName);
        }
        return $tables;
    }
}