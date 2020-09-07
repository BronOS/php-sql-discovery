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


use BronOS\PhpSqlSchema\Relation\Action\ActionInterface;
use BronOS\PhpSqlSchema\Relation\Action\CascadeAction;
use BronOS\PhpSqlSchema\Relation\Action\CascadeActionInterface;
use BronOS\PhpSqlSchema\Relation\Action\NoAction;
use BronOS\PhpSqlSchema\Relation\Action\NoActionInterface;
use BronOS\PhpSqlSchema\Relation\Action\RestrictAction;
use BronOS\PhpSqlSchema\Relation\Action\RestrictActionInterface;
use BronOS\PhpSqlSchema\Relation\Action\SetDefaultAction;
use BronOS\PhpSqlSchema\Relation\Action\SetDefaultActionInterface;
use BronOS\PhpSqlSchema\Relation\Action\SetNullAction;
use BronOS\PhpSqlSchema\Relation\Action\SetNullActionInterface;
use BronOS\PhpSqlSchema\Relation\ForeignKey;
use BronOS\PhpSqlSchema\Relation\ForeignKeyInterface;

/**
 * Relation/Foreign key factory.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class ForeignKeyFactory implements ForeignKeyFactoryInterface
{
    /**
     * Makes foreign key object from database row.
     *
     * @param array $row
     *
     * @return ForeignKeyInterface
     */
    public function fromRow(array $row): ForeignKeyInterface
    {
        return new ForeignKey(
            $row[self::KEY_COLUMN_NAME],
            $row[self::KEY_REFERENCED_TABLE_NAME],
            $row[self::KEY_REFERENCED_COLUMN_NAME],
            $row[self::KEY_CONSTRAINT_NAME],
            $this->getAction($row[self::KEY_DELETE_RULE]),
            $this->getAction($row[self::KEY_UPDATE_RULE])
        );
    }

    private function getAction(string $actionName): ?ActionInterface
    {
        if ($actionName == CascadeActionInterface::SQL_KEYWORD) {
            return new CascadeAction();
        }

        if ($actionName == NoActionInterface::SQL_KEYWORD) {
            return new NoAction();
        }

        if ($actionName == SetDefaultActionInterface::SQL_KEYWORD) {
            return new SetDefaultAction();
        }

        if ($actionName == SetNullActionInterface::SQL_KEYWORD) {
            return new SetNullAction();
        }

        if ($actionName == RestrictActionInterface::SQL_KEYWORD) {
            return new RestrictAction();
        }

        return null;
    }
}