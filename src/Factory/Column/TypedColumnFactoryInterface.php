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

namespace BronOS\PhpSqlDiscovery\Factory\Column;


use BronOS\PhpSqlDiscovery\Exception\PhpSqlDiscoveryException;
use BronOS\PhpSqlSchema\Column\ColumnInterface;
use BronOS\PhpSqlSchema\Exception\ColumnDeclarationException;

/**
 * Typed column factory interface.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
interface TypedColumnFactoryInterface
{
    public const KEY_COLUMN_NAME = 'COLUMN_NAME';
    public const KEY_COLUMN_TYPE = 'COLUMN_TYPE';
    public const KEY_COLUMN_DEFAULT = 'COLUMN_DEFAULT';
    public const KEY_IS_NULLABLE = 'IS_NULLABLE';
    public const KEY_COLUMN_COMMENT = 'COLUMN_COMMENT';
    public const KEY_EXTRA = 'EXTRA';
    public const KEY_CHARACTER_SET_NAME = 'CHARACTER_SET_NAME';
    public const KEY_COLLATION_NAME = 'COLLATION_NAME';

    /**
     * Returns type of column.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Makes column object from database row.
     *
     * @param array $row
     *
     * @return ColumnInterface
     *
     * @throws PhpSqlDiscoveryException
     * @throws ColumnDeclarationException
     */
    public function fromRow(array $row): ColumnInterface;
}