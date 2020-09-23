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

namespace BronOS\PhpSqlDiscovery\Repository;


use BronOS\PhpSqlDiscovery\Exception\PhpSqlDiscoveryException;

/**
 * Abstract repository.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
abstract class AbstractRepository implements RepositoryInterface
{
    protected \PDO $pdo;

    /**
     * ColumnsRepository constructor.
     *
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $query
     * @param array  $binds
     *
     * @return array
     *
     * @throws PhpSqlDiscoveryException
     */
    protected function fetchAll(string $query, array $binds = []): array
    {
        $sth = $this->pdo->prepare($query);

        try {
            $sth->execute($binds);
        } catch (\PDOException $e) {
            throw new PhpSqlDiscoveryException($e->getMessage(), (int)$e->getCode(), $e);
        }

        return $sth->fetchAll();
    }

    /**
     * @param string $query
     * @param array  $binds
     *
     * @return array
     *
     * @throws PhpSqlDiscoveryException
     */
    protected function fetchOne(string $query, array $binds = []): array
    {
        $result = $this->fetchAll($query, $binds);

        if (count($result) == 0) {
            throw new PhpSqlDiscoveryException('Not found');
        }

        return $result[0];
    }

    /**
     * @param string $columnName
     * @param string $query
     * @param array  $binds
     *
     * @return string
     *
     * @throws PhpSqlDiscoveryException
     */
    protected function fetchColumn(string $columnName, string $query, array $binds = []): string
    {
        $result = $this->fetchOne($query, $binds);

        if (!isset($result[$columnName])) {
            throw new PhpSqlDiscoveryException('Column not found');
        }

        return (string)$result[$columnName];
    }

    /**
     * Finds database name.
     *
     * @return string
     *
     * @throws PhpSqlDiscoveryException
     */
    public function fetchDbName(): string
    {
        return $this->fetchColumn('dbname', 'SELECT database() AS dbname');
    }
}