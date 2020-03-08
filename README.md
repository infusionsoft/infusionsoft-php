# Infusionsoft PHP SDK

[![Build Status](https://travis-ci.org/infusionsoft/infusionsoft-php.png?branch=master)](https://travis-ci.org/infusionsoft/infusionsoft-php)
[![Total Downloads](https://poser.pugx.org/infusionsoft/php-sdk/downloads.png)](https://packagist.org/packages/infusionsoft/php-sdk)
[![Latest Stable Version](https://poser.pugx.org/infusionsoft/php-sdk/v/stable.png)](https://packagist.org/packages/infusionsoft/php-sdk)


## Version Notes

This version implements RESTful endpoints, a new version of Guzzle, and a restructured request handler.

As of version 1.4, PHP 7+ is required.

### Breaking Change

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
        "infusionsoft/php-sdk": "1.4.*"
    }
}
```

## Authentication

The client ID and secret are the key and secret for your OAuth2 application found at the [Infusionsoft Developers](https://keys.developer.infusionsoft.com/apps/mykeys) website.

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

## Laravel 5.1 Service Provider

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
 $data = Infusionsoft::data()->query("Contact",1000,0,['Id' => '123'],['Id','FirstName','LastName','Email'], 'Id', false);

 $data = app('infusionsoft')->data()->query("Contact",1000,0,['Id' => '123'],['Id','FirstName','LastName','Email'], 'Id', false);
```
## Codeigniter 4.0.2 (Stable Version) Support

- Install Codeigniter 4.0.2 framework app
- Install Infusionsoft-php SDK via composer (Codeigniter 4.0.2 Framework support added)

- Set your env variables

```
 INFUSIONSOFT_CLIENT_ID = 'xxxx'
 INFUSIONSOFT_SECRET = 'xxx'
 INFUSIONSOFT_REDIRECT= 'http://localhost/ci4/public/infusionsoftgithub/generatetokens'
```
- Create new Controller e.g Infusionsoftgithub.php in CI Controller folder

```
<?php
namespace App\Controllers;

use Infusionsoft;
use Infusionsoft\Http;

class Infusionsoftgithub extends BaseController {

    
    public function __construct() {

        $this->infusionsoft_oauth = new Infusionsoft\FrameworkSupport\Codeigniter\Codeigniter;
        
    }

    public function generateTokens() {
        
        //get infusionsoft objectS
            $infusionsoft = $this->infusionsoft_oauth->setvariables();
        
        //check if code exists in URL
                if ($this->request->getGet('code') != NULL) {
                    
        //try to exchange code with tokens        
                    try {
                    //generate token (this is a tokenized object and not a json string)
                        $tokens = $infusionsoft->requestAccessToken($this->request->getGet('code'));
                        
                    //store token parts in variables
                        
                        $extraInfo = $tokens->extraInfo;
                        $data['code'] = $this->request->getGet('code');
                        $data['full'] = $tokens;
                        $data['token_type'] = $extraInfo['token_type'];
                        $data['scope'] = $extraInfo['scope'];
                        $data['tokens'] = $tokens;
                        $data['accessToken'] = $tokens->accessToken;
                        $data['refreshToken'] = $tokens->refreshToken;
                        
                        //date and time of access token expiration expressed in seconds
                        $data['endOfLife'] = $tokens->endOfLife;
                        $appURL = substr($data['scope'], strpos($data['scope'], "|") + 1);
                        $data['appURL'] = $appURL;
                        $appName = str_replace(".infusionsoft.com","",$appURL);
                        $data['appName'] = $appName;
                        
                        //convert date and time of access token expiration from seconds to actual datetime
                        $data['expireTime'] = date('d-m-Y H:i:s', $tokens->endOfLife);
                        //time of token generation i.e the time when client authorized app to generate tokens
                        $data['tokentime'] = date('d-m-Y H:i:s',time());
                        
                    //create token string from generated token parts
                        $createdToken = [
                            "access_token" => $data['accessToken'],
                            "token_type" => $data['token_type'],
                            "expires_in" => 86400,
                            "refresh_token" => $data['refreshToken'],
                            "scope" => $data['scope']
                        ];
                        $data['fullCreated'] = json_encode($createdToken);
                        
                        $data['message'] = "Tokens generated successfully...";
                        $data['infusionsoft'] = $infusionsoft;
                        $data['buttontext'] = 'Click here to re-authorize';
                        
            //send data to a function to save tokens in db (this function is present in this controller)            
//                        $data['savetokensresult'] = $this->savetokens($data);
                        $data['savetokensresult'] = "Fake Saved";
                        
            //Load view with generate tokens and prompt to re-authorize app if client wants
                        echo view('infusionsoftgithub/generatetokens', $data);
                        
                            } 
            //catch error
                    catch (Http\HttpException $e) {
                        $data['date'] = date('d-m-Y H:i:s',time());
                        $data['message'] = $e->getMessage();
                        $data['infusionsoft'] = $infusionsoft;
                        $data['buttontext'] = 'Click here to re-authorize';
                        
            //Load view and show the error and prompt to authorize app
                        echo view('infusionsoftgithub/generatetokens', $data);
                        
//                      print_r($e);
//                      echo "Token Expired/Invalid Code...<br>";
                            
                            }
            
        }
        else {
                        $data['date'] = date('d-m-Y H:i:s',time());
                        $data['message'] = "Please authorize the app...";
                        $data['infusionsoft'] = $infusionsoft;
                        $data['buttontext'] = 'Click here to authorize';
            
            //Load view
                        echo view('infusionsoftgithub/generatetokens', $data);
        }
    }
    
```

- Create new view files e.g infusionsoftgithub/generatetokens (create new folder 'infusionsoftgithub' in view folder and new file generatetokens.php

```
<?php
$request = \Config\Services::request();
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo site_name; ?></title>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://accounts.infusionsoft.com/bootstrap-3.2.0-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://accounts.infusionsoft.com/css/bootstrap-app-central.css?b=1.0.210">
    <link rel="stylesheet" href="https://accounts.infusionsoft.com/css/keap-branding.css?b=1.0.210">
	<style type="text/css">

	</style>
</head>
<body>
	<nav class="navbar navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#central-navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="https://accounts.infusionsoft.com/app/central/home">
                <img src="https://accounts.infusionsoft.com/img/keap_logo.svg?b=1.0.210" height="30px" width="18px">
                    <span class="vertical-bar">|</span>
                    Infusionsoft
                </a>
            </div>
            
                <div class="hidden-xs">
                    <p class="navbar-text navbar-right">
                        <strong>Infusionsoft | Codeigniter4</strong>
                        Generate Tokens for Infusionsoft
                        <span class="vertical-bar">|</span>
                        <a class="navbar-link" href="<?php echo base_url() ?>">Home</a>
                    </p>
                </div>
            

        </div>
    </nav>
    <div class="container">
    <div class="row">
        <div class="col-xs-12 text-center">
            <div class="page-header">
                
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-6 col-lg-5 col-centered">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php if($request->getVar('error') != NULL){ ?>
                    <p><?php echo $request->getVar('error_description'); } else { ?></p>
                    <p><?php echo $message; } ?></p>
                    
                    <?php if (isset($appName)): ?>
                    <p><?php   
//                        print_r($tokens);
//                        echo "<br>";
                        print_r("<strong>code</strong>: ".$request->getVar('code')."<br>");
                        print_r("<strong>accessToken</strong>: ".$accessToken."<br>");
                        print_r("<strong>refreshToken:</strong> ".$refreshToken."<br>");
                        print_r("<strong>endOfLife:</strong> ".$endOfLife."<br>");
                        print_r("<strong>token_type:</strong> ".$token_type."<br>");
                        print_r("<strong>scope:</strong> ".$scope."<br>");
                        print_r("<strong>appURL:</strong> ".$appURL."<br>");
                        print_r("<strong>appName:</strong> ".$appName."<br>");
                        print_r("<strong>accessToken expireTime:</strong> ".$expireTime."<br>");
                        print_r("<strong>Token Saved in db:</strong> ".$savetokensresult."<br>");
                        
                        
                        //add contact
                        $contactDetails =[
            'FirstName' => "jhon", 
            'LastName' => "doe", 
            'Email' => "johndoe@johndoe.com"
        ];

        
        echo "<pre>Sample data: <br>";
        


    $conID = $infusionsoft->contacts('xml')->addWithDupCheck($contactDetails, 'Email');
    print_r(json_encode($contactDetails, JSON_PRETTY_PRINT));
    print_r("<br>added in IS, conID: ".$conID);
                        echo "</pre>";
                        
                        
                        
                        ?></p>
                    <?php else: ?>
                    <?php endif ?>
                    
<?php echo '<a class="btn btn-primary center-block" href="' . $infusionsoft->getAuthorizationUrl() . '">'.$buttontext.'</a>'; ?>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>
</html>
```

Access 'Allow'/'Deny' Screen from your controller by accessing the URL in browser e.g http://base_url/infusionsoftgithub/generateTokens.

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

## Contributing

Please see [CONTRIBUTING](https://github.com/infusionsoft/infusionsoft-php/blob/master/CONTRIBUTING.md) for details.


## License

The MIT License (MIT). Please see [License File](https://github.com/infusionsoft/infusionsoft-php/blob/master/LICENSE) for more information.
