# What is Yer?

Yer is a PHP [geolocation] library.

## Usage
Install it via composer `eabay/yer`

### Locator Providers
#### `Geobytes`
``` php
<?php
require_once __DIR__.'/vendor/autoload.php';

$geolocation = new Yer\Geolocation;
$geolocation->setLocator(new Yer\Locator\GeobytesLocator());

var_dump($geolocation->lookup('193.140.215.133'));
```

You can turn ssl on/off:
``` php
<?php
...
$geolocation->setLocator(new Yer\Locator\GeobytesLocator(true));
```

If you have a paid subscription,
``` php
<?php
...
$geolocation->setLocator(new Yer\Locator\GeobytesLocator(true /* or false */, 'your email', 'your password'));
```

#### `MaxMind`
``` php
<?php
...
$geolocation->setLocator(new Yer\Locator\MaxMindWebServiceLocator('your license key'));
```

You can use your custom locator providers by implementing `Yer\Locator\LocatorInterface`.

### IP Address Validation
You can validate IP address before query to the locator provider
``` php
<?php
...
$geolocation->setIpValidator(new Yer\Validator\IpValidator())
```

If you want to use your own validator implement `Yer\Validator\ValidatorInterface`


[geolocation]: http://en.wikipedia.org/wiki/Geolocation