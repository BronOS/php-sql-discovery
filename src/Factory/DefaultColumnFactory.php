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


use BronOS\PhpSqlDiscovery\Factory\Column\BigIntColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\BinaryColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\BitColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\BlobColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\CharColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\DateColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\DateTimeColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\DecimalColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\DoubleColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\EnumColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\FloatColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\IntColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\JsonColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\LongBlobColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\LongTextColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\MediumBlobColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\MediumIntColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\MediumTextColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\SetColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\SmallIntColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\TextColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\TimeColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\TimestampColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\TinyBlobColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\TinyIntColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\TinyTextColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\VarBinaryColumnFactory;
use BronOS\PhpSqlDiscovery\Factory\Column\VarCharColumnFactory;

/**
 * Default column factory.
 *
 * @package   bronos\php-sql-discovery
 * @author    Oleg Bronzov <oleg.bronzov@gmail.com>
 * @copyright 2020
 * @license   https://opensource.org/licenses/MIT
 */
class DefaultColumnFactory extends ColumnFactory
{
    /**
     * DefaultColumnFactory constructor.
     */
    public function __construct()
    {
        parent::__construct(
            new BigIntColumnFactory(),
            new BinaryColumnFactory(),
            new BitColumnFactory(),
            new BlobColumnFactory(),
            new CharColumnFactory(),
            new DateColumnFactory(),
            new DateTimeColumnFactory(),
            new DecimalColumnFactory(),
            new DoubleColumnFactory(),
            new EnumColumnFactory(),
            new FloatColumnFactory(),
            new IntColumnFactory(),
            new LongBlobColumnFactory(),
            new LongTextColumnFactory(),
            new MediumBlobColumnFactory(),
            new MediumIntColumnFactory(),
            new MediumTextColumnFactory(),
            new SetColumnFactory(),
            new SmallIntColumnFactory(),
            new TextColumnFactory(),
            new TimeColumnFactory(),
            new TimestampColumnFactory(),
            new TinyBlobColumnFactory(),
            new TinyIntColumnFactory(),
            new TinyTextColumnFactory(),
            new VarBinaryColumnFactory(),
            new VarCharColumnFactory(),
            new JsonColumnFactory()
        );
    }
}