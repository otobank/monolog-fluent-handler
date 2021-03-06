Monolog Fluent Handler
======================

[![Latest Stable Version](https://poser.pugx.org/otobank/monolog-fluent-handler/v/stable)](https://packagist.org/packages/otobank/monolog-fluent-handler) [![Total Downloads](https://poser.pugx.org/otobank/monolog-fluent-handler/downloads)](https://packagist.org/packages/otobank/monolog-fluent-handler) [![Latest Unstable Version](https://poser.pugx.org/otobank/monolog-fluent-handler/v/unstable)](https://packagist.org/packages/otobank/monolog-fluent-handler) [![License](https://poser.pugx.org/otobank/monolog-fluent-handler/license)](https://packagist.org/packages/otobank/monolog-fluent-handler) [![Build Status](https://travis-ci.org/otobank/monolog-fluent-handler.svg?branch=master)](https://travis-ci.org/otobank/monolog-fluent-handler) [![Coverage Status](https://coveralls.io/repos/otobank/monolog-fluent-handler/badge.svg?branch=master)](https://coveralls.io/r/otobank/monolog-fluent-handler?branch=master) [![Dependency Status](https://gemnasium.com/badges/github.com/otobank/monolog-fluent-handler.svg)](https://gemnasium.com/github.com/otobank/monolog-fluent-handler)

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
