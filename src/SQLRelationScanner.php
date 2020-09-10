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
use BronOS\PhpSqlDiscovery\Factory\ForeignKeyFactoryInterface;
use BronOS\PhpSqlDiscovery\Repository\ForeignKeyRepositoryInterface;
use BronOS\PhpSqlSchema\Relation\ForeignKeyInterface;

/**
 * Relation/Foreign key scanner.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class SQLRelationScanner implements SQLRelationScannerInterface
{
    private ForeignKeyRepositoryInterface $repository;
    private ForeignKeyFactoryInterface $factory;

    /**
     * SQLRelationScanner constructor.
     *
     * @param ForeignKeyRepositoryInterface $repository
     * @param ForeignKeyFactoryInterface    $factory
     */
    public function __construct(ForeignKeyRepositoryInterface $repository, ForeignKeyFactoryInterface $factory)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    /**
     * Scans all relations in the database table.
     *
     * @param string $tableName
     *
     * @return ForeignKeyInterface[]
     *
     * @throws PhpSqlDiscoveryException
     */
    public function scan(string $tableName): array
    {
        return array_map([$this->factory, 'fromRow'], $this->repository->findAll($tableName));
    }
}