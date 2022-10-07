<?php
/**
 * Utopia PHP Framework
 *
 * @package AB
 * @subpackage Tests
 *
 * @link https://github.com/utopia-php/framework
 * @author Eldad Fux <eldad@appwrite.io>
 * @version 1.0 RC4
 * @license The MIT License (MIT) <http://www.opensource.org/licenses/mit-license.php>
 */

namespace Utopia\Tests;

use Exception;
use Utopia\AB\Test;
use PHPUnit\Framework\TestCase;

class TestTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function tearDown(): void
    {
    }

    public function testTest(): void
    {
        $test = new Test('unit-test');

        $test
            ->variation('title1', 'Title: Hello World', 40) // 40% probability
            ->variation('title2', 'Title: Foo Bar', 30) // 30% probability
            ->variation('title3', function () {
                return 'Title: Title from a callback function';
            }, 30) // 30% probability
        ;

        for($i=0; $i<100; $i++) {
            $value = \strval($test->run());

            $this->assertStringStartsWith('Title:', $value);
        }

        $test
            ->variation('title1', 'Title: Hello World', 100) // 100% probability
            ->variation('title2', 'Title: Foo Bar', 0) // 0% probability
            ->variation('title3', function () {
                return 'Title: Title from a callback function';
            }, 0) // 0% probability
        ;

        for($i=0; $i<100; $i++) {
            $value = $test->run();

            $this->assertEquals('Title: Hello World', $value);
        }


        $test = new Test('another-test');

        $test
            ->variation('option1', 'title1')
            ->variation('option2', 'title2')
            ->variation('option3', 'title3')
        ;

        $test->run();

        $results = Test::results();

        $this->assertArrayHasKey('unit-test', $results);
        $this->assertArrayHasKey('another-test', $results);
    }
}