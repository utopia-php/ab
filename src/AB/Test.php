<?php

namespace Utopia\AB;

use Exception;

class Test {

    /**
     * @var array
     */
    static protected $results = [];

    /**
     * Get Result of All Tests
     *
     * @return array
     */
    static public function results()
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
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Add a New Variation to Test
     *
     * @param $name
     * @param $value
     * @param $probability
     * @return Test
     */
    public function variation($name, $value, $probability = null)
    {
        $this->variations[$name] = $value;
        $this->probabilities[$name] = $probability;

        return $this;
    }

    /**
     * Run Test and Get Result
     *
     * @throws Exception
     */
    public function run()
    {
        $result = $this->chance();

        $return = $this->variations[$result];

        if(is_callable($return)) {
            $return = $return();
        }

        self::$results[$this->name] = $return;

        return $return;
    }

    /**
     * Get Random Variation Based on Probabilities Chance
     *
     * @return string
     * @throws Exception
     */
    protected function chance()
    {
        $sum = 0;
        $empty = 0;

        foreach ($this->probabilities as $name => $value) {
            $sum += $value;

            if(empty($value)) {
                $empty++;
            }
        }

        if($sum > 100) {
            throw new Exception('Test Error: Total variation probabilities is bigger than 100%');
        }

        if($sum < 100) { // Auto set probability when it has no value
            foreach ($this->probabilities as $name => $value) {
                if(empty($value)) {
                    $this->probabilities[$name] = (100 - $sum) / $empty;
                }
            }
        }

        $number     = rand(0, array_sum($this->probabilities) * 10);
        $starter    = 0;
        $return     = null;

        foreach($this->probabilities as $key => $val) {
            $starter += $val * 10;

            if($number <= $starter) {
                $return = $key;
                break;
            }
        }

        return $return;
    }
}