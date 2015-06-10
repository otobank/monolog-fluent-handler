Monolog Fluent Handler [![Build Status](https://travis-ci.org/otobank/monolog-fluent-handler.svg?branch=master)](https://travis-ci.org/otobank/monolog-fluent-handler) [![Coverage Status](https://coveralls.io/repos/otobank/monolog-fluent-handler/badge.svg?branch=master)](https://coveralls.io/r/otobank/monolog-fluent-handler?branch=master)
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

### Symfony

example) **`app/config/config.yml`**

```yaml
services:
    acme.monolog.fluent_handler:
        class: Otobank\Monolog\Handler\FluentHandler
        arguments:
            - "%acme.fluent.uri%"

monolog:
    handlers:
        fluent:
            type: service
            id: acme.monolog.fluent_handler
            level: debug
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
