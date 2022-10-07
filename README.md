# Utopia AB Tests

[![Build Status](https://travis-ci.org/utopia-php/ab.svg?branch=master)](https://travis-ci.com/utopia-php/ab)
![Total Downloads](https://img.shields.io/packagist/dt/utopia-php/ab.svg)
[![Discord](https://img.shields.io/discord/564160730845151244?label=discord)](https://appwrite.io/discord)

Utopia AB Tests library is simple and lite library for managing AB tests on the server side. This library is aiming to be as simple and easy to learn and use. This library is maintained by the [Appwrite team](https://appwrite.io).

Although this library is part of the [Utopia Framework](https://github.com/utopia-php/framework) project it is dependency free and can be used as standalone with any other PHP project or framework.

## Getting Started

Install using composer:
```bash
composer require utopia-php/ab
```

```php
<?php

require_once '../vendor/autoload.php';

use Utopia\AB\Test;

$test = new Test('example');

$test
    ->variation('title1', 'Hello World', 40) // 40% probability
    ->variation('title2', 'Foo Bar', 30) // 30% probability
    ->variation('title3', function () { // 30% probability
        return 'Title from a callback function';
    }, 30)
;
    
$debug  = [];
    
for($i=0; $i<10000; $i++) {
    $debug[$test->run()]++;
}
    
var_dump($debug);
    
```

If no probability value is passed to the variation, all variations with no probability values will be given equal values from the remaining 100% of the test variations.

When passing a closure as value for your variation the callback will be executed only once the test is being run using the Test::run() method.

## System Requirements

Utopia Framework requires PHP 8.0 or later. We recommend using the latest PHP version whenever possible.

## Authors

**Eldad Fux**

+ [https://twitter.com/eldadfux](https://twitter.com/eldadfux)
+ [https://github.com/eldadfux](https://github.com/eldadfux)

## Copyright and license

The MIT License (MIT) [http://www.opensource.org/licenses/mit-license.php](http://www.opensource.org/licenses/mit-license.php)
