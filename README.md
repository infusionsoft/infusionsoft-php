# Infusionsoft PHP SDK (beta)

[![Build Status](https://travis-ci.org/infusionsoft/infusionsoft-php.png?branch=master)](https://travis-ci.org/infusionsoft/infusionsoft-php)
[![Total Downloads](https://poser.pugx.org/infusionsoft/php-sdk/downloads.png)](https://packagist.org/packages/infusionsoft/php-sdk)
[![Latest Stable Version](https://poser.pugx.org/infusionsoft/php-sdk/v/stable.png)](https://packagist.org/packages/infusionsoft/php-sdk)


## Version Notes

This version implements a newer version of the xml-rpc handling library. As such, the minimum PHP version has been increased to >= 5.4

## Install

Using the composer CLI:

```
composer require infusionsoft/php-sdk
```

Or manually add it to your composer.json:

``` json
{
    "require": {
        "infusionsoft/php-sdk": "1.1.*"
    }
}
```

## Usage

The client ID and secret are the key and secret for your OAuth2 application found at the [Infusionsoft Developers](https://keys.developer.infusionsoft.com/apps/mykeys) website.

```php
require_once 'vendor/autoload.php';

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId'     => 'XXXXXXXXXXXXXXXXXXXXXXXX',
	'clientSecret' => 'XXXXXXXXXX',
	'redirectUri'  => 'http://example.com/',
));

// If the serialized token is available in the session storage, we tell the SDK
// to use that token for subsequent requests.
if (isset($_SESSION['token'])) {
	$infusionsoft->setToken(unserialize($_SESSION['token']));
}

// If we are returning from Infusionsoft we need to exchange the code for an
// access token.
if (isset($_GET['code']) and !$infusionsoft->getToken()) {
	$infusionsoft->requestAccessToken($_GET['code']);
}

if ($infusionsoft->getToken()) {
	// Save the serialized token to the current session for subsequent requests
	$_SESSION['token'] = serialize($infusionsoft->getToken());

	$infusionsoft->contacts->add(array('FirstName' => 'John', 'LastName' => 'Doe'));
} else {
	echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}
```

### Dates

DateTime objects are now used instead of a DateTime string where the date(time) is a parameter in the method.

```php
$datetime = new \DateTime('now',new \DateTimeZone('America/New_York'));
```

### Debugging

To enable debugging of requests and responses, you need to set the debug flag to try by using:

```php
$infusionsoft->setDebug(true);
```

Once enabled, logs will by default be written to an array that can be accessed by:

```php
$infusionsoft->getLogs();
```

You can utilize the powerful logging plugin built into Guzzle by using one of the available adapters. For example, to use the Monolog writer to write to a file:

```php
use Guzzle\Log\MonologLogAdapter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = new Logger('client');
$logger->pushHandler(new StreamHandler('infusionsoft.log'));

$infusionsoft->setHttpLogAdapter(new MonologLogAdapter($logger));
```

## Testing

``` bash
$ phpunit
```

## Laravel/Lumen Providers

In config/app.php, register the service provider

```
Infusionsoft\FrameworkSupport\Laravel\InfusionsoftServiceProvider::class,
```

Register the Facade (optional)

```
'Infusionsoft'       => Infusionsoft\FrameworkSupport\Laravel\InfusionsoftFacade::class
```

Publish the config

```
php artisan vendor:publish --provider="Infusionsoft\FrameworkSupport\Laravel\InfusionsoftServiceProvider"
```

Set your env variables

```
INFUSIONSOFT_CLIENT_ID=xxxxxxxx
INFUSIONSOFT_SECRET=xxxxxxxx
INFUSIONSOFT_REDIRECT_URL=http://localhost/auth/callback
```

Access Infusionsoft from the Facade or Binding

```
 $data = Infusionsoft::query("Contact",1000,0,['Id' => '123'],['Id','FirstName','LastName','Email']);

 $data = app('infusionsoft')->query("Contact",1000,0,['Id' => '123'],['Id','FirstName','LastName','Email']);
```

## Contributing

Please see [CONTRIBUTING](https://github.com/infusionsoft/infusionsoft-php/blob/master/CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](https://github.com/infusionsoft/infusionsoft-php/blob/master/LICENSE) for more information.
