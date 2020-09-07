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


use BronOS\PhpSqlDiscovery\Exception\PhpSqlDiscoveryException;
use BronOS\PhpSqlDiscovery\Factory\Column\TypedColumnFactoryInterface;
use BronOS\PhpSqlSchema\Column\ColumnInterface;
use BronOS\PhpSqlSchema\Exception\ColumnDeclarationException;

/**
 * Column factory.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class ColumnFactory implements ColumnFactoryInterface
{
    /**
     * @var TypedColumnFactoryInterface[] Factories map
     */
    private array $typedColumnFactories = [];

    /**
     * ColumnFactory constructor.
     *
     * @param TypedColumnFactoryInterface[] $typedColumnFactories
     */
    public function __construct(TypedColumnFactoryInterface ...$typedColumnFactories)
    {
        foreach ($typedColumnFactories as $typedColumnFactory) {
            $this->typedColumnFactories[$typedColumnFactory->getType()] = $typedColumnFactory;
        }
    }

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
    public function fromRow(array $row): ColumnInterface
    {
        return $this->getTypedColumnFactory($row[self::KEY_DATA_TYPE])->fromRow($row);
    }

    /**
     * @param string $type
     *
     * @return TypedColumnFactoryInterface
     * @throws PhpSqlDiscoveryException
     */
    private function getTypedColumnFactory(string $type):TypedColumnFactoryInterface
    {
        $type = strtolower($type);
        if (!isset($this->typedColumnFactories[$type])) {
            throw new PhpSqlDiscoveryException("Unknown column type [$type]");
        }

        return $this->typedColumnFactories[$type];
    }
}