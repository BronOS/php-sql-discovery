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
 * Defaults repository.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class DefaultsRepository extends AbstractRepository implements DefaultsRepositoryInterface
{
    /**
     * Find defaults metadata of a database and returns it as a raw array.
     *
     * @return array
     *
     * @throws PhpSqlDiscoveryException
     */
    public function findInfo(): array
    {
        return $this->fetchOne("
                SELECT 
                   S.default_character_set_name, 
                   S.default_collation_name,
                   (SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE SUPPORT = 'DEFAULT' LIMIT 1) AS default_engine
                FROM information_schema.schemata S
                WHERE S.schema_name = ?;
            ",
            [$this->fetchDbName()]
        );
    }
}