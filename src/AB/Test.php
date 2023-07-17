<?php

namespace Utopia\AB;

use Exception;

class Test
{
    /**
     * @var array
     */
    protected static $results = [];

    /**
     * Get Result of All Tests
     *
     * @return array
     */
    public static function results()
    {
        return self::$results;
    }

    /**
     * Test Name
     *
     * @var string
     */
    protected $name = '';

    /**
     * Test Variations
     *
     * @var array
     */
    protected $variations = [];

    /**
     * Test Variations Probabilities
     *
     * @var array
     */
    protected $probabilities = [];

    /**
     * Test constructor.
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Add a New Variation to Test
     *
     * @param  mixed  $value
     * @return $this
     */
    public function variation(string $name, $value, int $probability = null): self
    {
        $this->variations[$name] = $value;
        $this->probabilities[$name] = $probability;

        return $this;
    }

    /**
     * Run Test and Get Result
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function run()
    {
        $result = $this->chance();

        $return = $this->variations[$result];

        if (\is_callable($return)) {
            $return = $return();
        }

        self::$results[$this->name] = $return;

        return $return;
    }

    /**
     * Get Random Variation Based on Probabilities Chance
     *
     *
     * @throws Exception
     */
    protected function chance(): string
    {
        $sum = 0;
        $empty = 0;

        foreach ($this->probabilities as $name => $value) {
            $sum += $value;

            if (empty($value)) {
                $empty++;
            }
        }

        if ($sum > 100) {
            throw new Exception('Test Error: Total variation probabilities is bigger than 100%');
        }

        if ($sum < 100) { // Auto set probability when it has no value
            foreach ($this->probabilities as $name => $value) {
                if (empty($value)) {
                    $this->probabilities[$name] = (100 - $sum) / $empty;
                }
            }
        }

        $number = \rand(0, (int) \array_sum($this->probabilities) * 10);
        $starter = 0;
        $return = '';

        foreach ($this->probabilities as $key => $val) {
            $starter += $val * 10;

            if ($number <= $starter) {
                $return = $key;
                break;
            }
        }

        return $return;
    }
}
