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
 * Foreign key repository.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class ForeignKeyRepository extends AbstractRepository implements ForeignKeyRepositoryInterface
{
    /**
     * Find foreign key and returns it as a raw array.
     *
     * @param string $tableName
     *
     * @return array
     *
     * @throws PhpSqlDiscoveryException
     */
    public function findAll(string $tableName): array
    {
        return $this->fetchAll("
            SELECT 
                   KCU.CONSTRAINT_NAME, 
                   KCU.COLUMN_NAME, 
                   KCU.REFERENCED_TABLE_NAME, 
                   KCU.REFERENCED_COLUMN_NAME, 
                   RC.UPDATE_RULE, 
                   RC.DELETE_RULE
            FROM `INFORMATION_SCHEMA`.`KEY_COLUMN_USAGE` KCU
            LEFT JOIN `INFORMATION_SCHEMA`.`REFERENTIAL_CONSTRAINTS` RC ON (
                RC.`TABLE_NAME` = :table 
                    AND 
                RC.`CONSTRAINT_SCHEMA` = :schema 
                    AND 
                KCU.CONSTRAINT_NAME = RC.CONSTRAINT_NAME
            )
            WHERE
                KCU.`TABLE_NAME` = :table 
                    AND
                KCU.`CONSTRAINT_SCHEMA` = :schema 
                    AND
                KCU.`REFERENCED_TABLE_NAME` IS NOT NULL;
        ", [
            ':table' => $tableName,
            ':schema' => $this->fetchDbName(),
        ]);
    }
}