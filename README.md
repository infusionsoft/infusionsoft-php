# Infusionsoft PHP SDK

> [!WARNING]
> **⚠️ Deprecated**
> This SDK is no longer actively maintained.
> Please migrate to the replacement: [`keap-sdk-php`](https://github.com/infusionsoft/keap-sdk-php), available on [Packagist](https://packagist.org/packages/keap/keap-sdk).
> 
> You can use the [Migration guide from infusionsoft/php-sdk](https://github.com/infusionsoft/keap-sdk-php/blob/main/MigrationFromInfusionsoftPhpSdk.md).

[![Total Downloads](https://poser.pugx.org/infusionsoft/php-sdk/downloads.png)](https://packagist.org/packages/infusionsoft/php-sdk)
[![Latest Stable Version](https://poser.pugx.org/infusionsoft/php-sdk/v/stable.png)](https://packagist.org/packages/infusionsoft/php-sdk)


## Version Notes

This version implements RESTful endpoints, a new version of Guzzle, and a restructured request handler.

As of version 1.6, PHP 8.1+ is required.

### Breaking Change

With the Guzzle 7 upgrade, there was a refactor on the `request` function name in Infusionsoft\Http\ClientInterface. If you created a custom HttpClient, you'll need to update to use the new function name of `call` 

If you use the `Contacts`, `Orders` or `Products` services, there are now two different classes handling each service - one for REST, one for XML-RPC. *This version of the SDK will load the REST class by default.* If you still need the XML-RPC class, pass `'xml'` as an argument when requesting the object: `$infusionsoft->orders('xml')'`

Kudos to [toddstoker](https://github.com/toddstoker) and [mattmerrill](https://github.com/mattmerrill) for their contributions to this release.

## Install

Using the composer CLI:

```
composer require infusionsoft/php-sdk
```

Or manually add it to your composer.json:

``` json
{
    "require": {
        "infusionsoft/php-sdk": "1.6.*"
    }
}
```

## Authentication

Currently Keap supports two types of authentication for our APIs: the OAuth2 Access Code Grant and API Keys.  
Developers of third-party integrations should always use our OAuth2 authentication, but developers building integrations for a single tenant may find the use of API Keys much simpler.

### OAuth2 Access Code Grant

The client ID and secret are the key and secret for your OAuth2 application found at the [Infusionsoft Developers](https://keys.developer.keap.com) website.

```php

if(empty(session_id();)) session_start();

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
	$_SESSION['token'] = serialize($infusionsoft->requestAccessToken($_GET['code']));
}

if ($infusionsoft->getToken()) {
	// Save the serialized token to the current session for subsequent requests
	$_SESSION['token'] = serialize($infusionsoft->getToken());

	// MAKE INFUSIONSOFT REQUEST
} else {
	echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}
```

### API Keys

API Keys are a "password" for your data in an application and should always be treated like a dangerous secret. 

In our UI you will find an API Settings screen which divides API Keys into two distinct categories:
* `Personal Access Tokens`, which are scoped to your own user account and can only see and manipulate the data you have access to.
* `Service Account Keys`, which can only be authorized by an Administrator and have full access to the data stored in the application.

For additional information on how to authorize and use PATs and SAKs please see our [developer documentation](https://developer.infusionsoft.com/pat-and-sak/).

```php
require_once 'vendor/autoload.php';

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
  'apikey' => $APIKeyRetrievedFromCredentialStorage,
));

// MAKE INFUSIONSOFT REQUEST
```

## Making XML-RPC Requests

```php
require_once 'vendor/autoload.php';

//
// Setup your Infusionsoft object here, then set your token either via the request or from storage
// As of v1.3 contacts defaults to rest
$infusionsoft->setToken($myTokenObject);

$infusionsoft->contacts('xml')->add(array('FirstName' => 'John', 'LastName' => 'Doe'));

```

## Making REST Requests

The PHP SDK is setup to allow easy access to REST endpoints. In general, a single result is returned as a Class representing
 that object, and multiple objects are returned as an Infusionsoft Collection, which is simply a wrapper around an array
 of results making them easier to manage.

 The standard REST operations are mapped to a series of simple functions. We'll use the Tasks service for our examples,
 but the operations below work on all documented Infusionsoft REST services.

 To retrieve all tasks:

 ```php
 $tasks = $infusionsoft->tasks()->all();
 ```

 To retrieve a single task:

 ```php
 $task = $infusionsoft->tasks()->find($taskId);
 ```

 To query only completed tasks:

 ```php
 $tasks = $infusionsoft->tasks()->where('status', 'completed')->get();
 ```

 You can chain `where()` as many times as you'd like, or you can pass an array:

 ```php
 $tasks = $infusionsoft->tasks()->where(['status' => 'completed', 'user_id' => '45'])->get();
 ```

 To create a task:
 ```php
 $task = $infusionsoft->tasks()->create([
    'title' => 'My First Task',
    'description' => 'Better get it done!'
 ]);
 ```

 Then update that task:
 ```php
 $task->title = 'A better task title';
 $task->save();
 ```

 And finally, to delete the task:
 ```php
 $task->delete();
 ```

 Several REST services have a `/sync` endpoint, which we provide a helper method for:
 ```php
 $tasks = $infusionsoft->tasks()->sync($syncId);
 ```

 This returns a list of tasks created or updated since the sync ID was last generated.


```php
require_once 'vendor/autoload.php';

//
// Setup your Infusionsoft object here, then set your token either via the request or from storage
//
$infusionsoft->setToken($myTokenObject);

$infusionsoft->tasks()->find('1');

```


### Dates

DateTime objects are used instead of a DateTime string where the date(time) is a parameter in the method.

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
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = new Logger('client');
$logger->pushHandler(new StreamHandler('infusionsoft.log'));

$infusionsoft->setHttpLogAdapter($logger);
```

## Testing

``` bash
$ phpunit
```

## Laravel Framework Support

### Laravel < 5.5

In config/app.php, register the service provider

```
Infusionsoft\FrameworkSupport\Laravel\InfusionsoftServiceProvider::class,
```

Register the Facade (optional)

```
'Infusionsoft'       => Infusionsoft\FrameworkSupport\Laravel\InfusionsoftFacade::class
```

### Laravel >= 5.5

In Laravel 5.5, package auto-discovery was added. The service provider and facade will be detected for you. Continue by publishing the vendor assets and adding your env variables.

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
 $data = Infusionsoft::data()->query("Contact",1000,0,['Id' => '123'],['Id','FirstName','LastName','Email'], 'Id', false);

 $data = app('infusionsoft')->data()->query("Contact",1000,0,['Id' => '123'],['Id','FirstName','LastName','Email'], 'Id', false);
```

## Lumen Service Provider

In bootstrap/app.php, register the service provider

```
$app->register(Infusionsoft\FrameworkSupport\Lumen\InfusionsoftServiceProvider::class);
```

Set your env variables (make sure you're loading your env file in app.php)

```
INFUSIONSOFT_CLIENT_ID=xxxxxxxx
INFUSIONSOFT_SECRET=xxxxxxxx
INFUSIONSOFT_REDIRECT_URL=http://localhost/auth/callback
```

Access Infusionsoft from the Binding

```
 $data = app('infusionsoft')->data()->query("Contact",1000,0,['Id' => '123'],['Id','FirstName','LastName','Email'], 'Id', false);
```

## SDK Development
You can install the Composer dependencies without installing Composer:
```
docker compose run composer
```

You can access the samples by spinning up the Docker container for the Composer dependencies:
```
docker compose up -d
```

Tests can be executed without installing PHP in the host environment (while the main container is running):
```
docker exec -it infusionsoft-php /var/www/html/vendor/bin/phpunit tests
```

If using Docker for Windows, please see `.env` for additional details.
## Contributing

Please see [CONTRIBUTING](https://github.com/infusionsoft/infusionsoft-php/blob/master/CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](https://github.com/infusionsoft/infusionsoft-php/blob/master/LICENSE) for more information.
