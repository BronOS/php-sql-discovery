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

namespace BronOS\PhpSqlDiscovery\Factory;


use BronOS\PhpSqlSchema\Column\ColumnInterface;
use BronOS\PhpSqlSchema\Exception\DuplicateColumnException;
use BronOS\PhpSqlSchema\Exception\DuplicateIndexException;
use BronOS\PhpSqlSchema\Exception\DuplicateRelationException;
use BronOS\PhpSqlSchema\Exception\SQLTableSchemaDeclarationException;
use BronOS\PhpSqlSchema\Index\IndexInterface;
use BronOS\PhpSqlSchema\Relation\ForeignKeyInterface;
use BronOS\PhpSqlSchema\SQLTableSchema;
use BronOS\PhpSqlSchema\SQLTableSchemaInterface;

/**
 * Table factory.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class TableFactory implements TableFactoryInterface
{
    /**
     * Makes table object from database row.
     *
     * @param array                 $row
     * @param ColumnInterface[]     $columns
     * @param IndexInterface[]      $indexes
     * @param ForeignKeyInterface[] $relations
     *
     * @return SQLTableSchemaInterface
     * @throws DuplicateColumnException
     * @throws DuplicateIndexException
     * @throws DuplicateRelationException
     * @throws SQLTableSchemaDeclarationException
     */
    public function make(array $row, array $columns, array $indexes, array $relations): SQLTableSchemaInterface
    {
        return new SQLTableSchema(
            $row[self::KEY_TABLE_NAME],
            $columns,
            $indexes,
            $relations,
            $row[self::KEY_ENGINE],
            $row[self::KEY_CHARSET],
            $row[self::KEY_COLLATE] == $row[self::KEY_DEFAULT_COLLATION] ? null : $row[self::KEY_COLLATE]
        );
    }
}