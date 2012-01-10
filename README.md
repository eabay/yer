# What is Yer?

Yer is a PHP [geolocation] library.

## Usage
``` php
<?php
require_once __DIR__.'/../vendor/.composer/autoload.php';

use Yer\Geolocation;
use Yer\Locator\MaxMindWebServiceLocator;
use Yer\Validator\IpValidator;

$geolocation = new Geolocation;
$geolocation
    ->setLocator(new MaxMindWebServiceLocator('your license key'))
    ->setIpValidator(new IpValidator)
;

var_dump($geolocation->lookup('193.140.215.133'));
```

[geolocation]: http://en.wikipedia.org/wiki/Geolocation