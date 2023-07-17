<?php

namespace Utopia\Tests;

use PHPUnit\Framework\TestCase;
use Utopia\AB\Test;

class TestTest extends TestCase
{
    /**
     * @var Test
     */
    protected $test = null;

    public function setUp(): void
    {
        $this->test = new Test('unit-test');
    }

    public function tearDown(): void
    {
        $this->test = null;
    }

    public function testTest()
    {
        $this->test
            ->variation('title1', 'Title: Hello World', 40) // 40% probability
            ->variation('title2', 'Title: Foo Bar', 30) // 30% probability
            ->variation('title3', function () {
                return 'Title: Title from a callback function';
            }, 30); // 30% probability

        for ($i = 0; $i < 100; $i++) {
            $value = $this->test->run();

            $this->assertStringStartsWith('Title:', $value);
        }

        $this->test
            ->variation('title1', 'Title: Hello World', 100) // 100% probability
            ->variation('title2', 'Title: Foo Bar', 0) // 0% probability
            ->variation('title3', function () {
                return 'Title: Title from a callback function';
            }, 0); // 0% probability

        for ($i = 0; $i < 100; $i++) {
            $value = $this->test->run();

            $this->assertEquals('Title: Hello World', $value);
        }

        $test = new Test('another-test');

        $test
            ->variation('option1', 'title1')
            ->variation('option2', 'title2')
            ->variation('option3', 'title3');

        $test->run();

        $results = Test::results();

        $this->assertArrayHasKey('unit-test', $results);
        $this->assertArrayHasKey('another-test', $results);
    }
}
