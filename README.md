# Utopia AB Tests

[![Build Status](https://travis-ci.org/utopia-php/ab.svg?branch=master)](https://travis-ci.org/utopia-php/ab)
![Total Downloads](https://img.shields.io/packagist/dt/utopia-php/ab.svg)
![License](https://img.shields.io/github/license/utopia-php/ab.svg)

Utopia AB Tests library is simple and lite library for managing AB tests on the server side. This library is aiming to be as simple and easy to learn and use.

Although this library is part of the [Utopia Framework](https://github.com/utopia-php/framework) project it is dependency free and can be used as standalone with any other PHP project or framework.

## Getting Started

Install using composer:
```bash
composer require utopia-php/ab
```

script.php
```php
<?php

require_once '../vendor/autoload.php';

use Utopia\AB\Test;

$test = new Test('example');

$test
    ->variation('title1', 'Hello World', 40) // 40% probability
    ->variation('title2', 'Foo Bar', 30) // 30% probability
    ->variation('title3', function () {
        return 'Title from a callback function';
    }, 30) // 30% probability
;
    
$debug  = [];
    
for($i=0; $i<10000; $i++) {
    $debug[$test->run()]++;
}
    
var_dump($debug);
    
```

## System Requirements

Utopia Framework requires PHP 7.1 or later. We recommend using the latest PHP version whenever possible.

## Authors

**Eldad Fux**

+ [https://twitter.com/eldadfux](https://twitter.com/eldadfux)
+ [https://github.com/eldadfux](https://github.com/eldadfux)

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)