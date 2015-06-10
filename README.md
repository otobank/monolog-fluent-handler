Monolog Fluent Handler [![Build Status](https://travis-ci.org/otobank/monolog-fluent-handler.svg?branch=master)](https://travis-ci.org/otobank/monolog-fluent-handler)
======================

Monolog handler for Fluent.


Usage
-----

```php
<?php

use Monolog\Logger;
use Otobank\Monolog\Handler\FluentHandler;

$logger = new Logger('name');
$logger->pushHandler(new FluentHandler());

$logger->alert('Something wrong.');
```


Installation
------------

```
composer require otobank/monolog-fluent-handler
```


Author
------

SATO Keisuke - ksato@otobank.co.jp - https://github.com/riaf


License
-------

Licensed under the MIT License - see the [LICENSE](LICENSE) file for details


----

OTOBANK Inc.
