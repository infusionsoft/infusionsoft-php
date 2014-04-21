# Infusionsoft PHP SDK

[![Build Status](https://travis-ci.org/infusionsoft/php-sdk.png?branch=master)](https://travis-ci.org/infusionsoft/php-sdk)
[![Total Downloads](https://poser.pugx.org/infusionsoft/php-sdk/downloads.png)](https://packagist.org/packages/infusionsoft/php-sdk)
[![Latest Stable Version](https://poser.pugx.org/infusionsoft/php-sdk/v/stable.png)](https://packagist.org/packages/infusionsoft/php-sdk)


## Install

Via Composer

``` json
{
    "require": {
        "infusionsoft/php-sdk": "~1.0"
    }
}
```


## Usage

TODO

### Debugging

To enable debugging of requests and responses, you need to set the debug flag to try by using:

```
$infusionsoft->setDebug(true);
```

Once enabled, logs will by default be written to an array that can be accessed by:

```
$infusionsoft->getLogs();
```

You can utilize the powerful logging plugin built into Guzzle by using one of the available adapters. For example, to use the Monolog writer to write to a file:

```
use Guzzle\Log\MonologLogAdapter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

$logger = new Logger('client');
$logger->pushHandler(new StreamHandler('infusionsoft.log'));

$infusionsoft->setHttpLogAdapater(new MonologLogAdapter($logger));
```

## Testing

``` bash
$ phpunit
```


## Contributing

Please see [CONTRIBUTING](https://github.com/thephpleague/:package_name/blob/master/CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](https://github.com/thephpleague/:package_name/blob/master/LICENSE) for more information.
