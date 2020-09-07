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


use BronOS\PhpSqlSchema\Exception\DuplicateIndexFieldException;
use BronOS\PhpSqlSchema\Exception\EmptyIndexFieldListException;
use BronOS\PhpSqlSchema\Exception\InvalidIndexFieldTypeException;
use BronOS\PhpSqlSchema\Index\IndexInterface;
use BronOS\PhpSqlSchema\Index\Key;
use BronOS\PhpSqlSchema\Index\PrimaryKey;
use BronOS\PhpSqlSchema\Index\UniqueKey;

/**
 * Index factory.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class IndexFactory implements IndexFactoryInterface
{
    /**
     * Makes index objects list from database rows.
     *
     * @param array $rows
     *
     * @return IndexInterface[]
     */
    public function fromRows(array $rows): array
    {
        $indexes = [];

        foreach ($rows as $row) {
            if (!isset($indexes[$row[self::KEY_NAME]])) {
                $indexes[$row[self::KEY_NAME]] = $this->fromRow($row, $rows);
            }
        }

        return array_values($indexes);
    }

    /**
     * @param array $row
     * @param array $rows
     *
     * @return IndexInterface
     *
     * @throws DuplicateIndexFieldException
     * @throws EmptyIndexFieldListException
     * @throws InvalidIndexFieldTypeException
     */
    private function fromRow(array $row, array $rows): IndexInterface
    {
        if (strtoupper($row[self::KEY_NAME]) === self::PRIMARY_KEY) {
            return new PrimaryKey(
                $this->getFields($row[self::KEY_NAME], $rows)
            );
        }

        if ($row[self::KEY_NON_UNIQUE] == 0) {
            return new UniqueKey(
                $this->getFields($row[self::KEY_NAME], $rows),
                $row[self::KEY_COLUMN_NAME]
            );
        }

        return new Key(
            $this->getFields($row[self::KEY_NAME], $rows),
            $row[self::KEY_COLUMN_NAME]
        );
    }

    /**
     * @param string $keyName
     * @param array  $rows
     *
     * @return string[]
     */
    private function getFields(string $keyName, array $rows): array
    {
        $fields = [];

        foreach ($rows as $row) {
            if ($row[self::KEY_NAME] == $keyName) {
                $fields[] = $row[self::KEY_COLUMN_NAME];
            }
        }

        return $fields;
    }
}