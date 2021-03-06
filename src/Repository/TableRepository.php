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
 * Table repository.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class TableRepository extends AbstractRepository implements TableRepositoryInterface
{
    /**
     * Find table's info/metadata and returns it as a raw array.
     *
     * @param string $tableName
     *
     * @return array
     *
     * @throws PhpSqlDiscoveryException
     */
    public function findInfo(string $tableName): array
    {
        return $this->fetchOne("
                SELECT 
                       T.TABLE_NAME, 
                       T.ENGINE, 
                       T.TABLE_COLLATION, 
                       CCSA.CHARACTER_SET_NAME
                FROM information_schema.TABLES T
                LEFT JOIN information_schema.COLLATION_CHARACTER_SET_APPLICABILITY CCSA ON (
                    T.TABLE_COLLATION = CCSA.COLLATION_NAME
                )
                WHERE TABLE_NAME = ? AND TABLE_SCHEMA = ?
            ",
            [$tableName, $this->fetchDbName()]
        );
    }

    /**
     * Find all table's info/metadata and returns it as a raw array.
     *
     * @param array $ignoreTables
     *
     * @return array
     *
     * @throws PhpSqlDiscoveryException
     */
    public function findInfoAll(array $ignoreTables = []): array
    {
        $q = "SELECT 
               T.TABLE_NAME, 
               T.ENGINE, 
               T.TABLE_COLLATION, 
               CCSA.CHARACTER_SET_NAME
        FROM INFORMATION_SCHEMA.TABLES T
        LEFT JOIN INFORMATION_SCHEMA.COLLATION_CHARACTER_SET_APPLICABILITY CCSA ON (
            T.TABLE_COLLATION = CCSA.COLLATION_NAME
        )
        WHERE TABLE_SCHEMA = ?";

        if (count($ignoreTables) > 0) {
            $q .= " AND TABLE_NAME NOT IN ({$this->ignoreTablesToString($ignoreTables)})";
        }

        return $this->fetchAll($q, [$this->fetchDbName()]);
    }

    private function ignoreTablesToString(array $ignoreTables): string
    {
        return implode(", ", array_map(function (string $tableName) {
            return sprintf("'%s'", $tableName);
        }, $ignoreTables));
    }
}