<?php

session_start();

require_once '../vendor/autoload.php';

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
    'clientId' => '',
    'clientSecret' => '',
    'redirectUri' => '',
));

// By default, the SDK uses the Guzzle HTTP library for requests. To use CURL,
// you can change the HTTP client by using following line:
// $infusionsoft->setHttpClient(new \Infusionsoft\Http\CurlClient());

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

function add($infusionsoft, $email)
{
    $email1 = new \stdClass;
    $email1->field = 'EMAIL1';
    $email1->email = $email;
    $contact = ['given_name' => 'John', 'family_name' => 'Doe', 'email_addresses' => [$email1]];

    return $infusionsoft->contacts()->create($contact);
}

if ($infusionsoft->getToken()) {
    try {

        $email = 'john.doe4@example.com';

        try {
            $cid = $infusionsoft->contacts()->where('email', $email)->first();
        } catch (\Infusionsoft\InfusionsoftException $e) {
            $cid = add($infusionsoft, $email);
        }

    } catch (\Infusionsoft\TokenExpiredException $e) {
        // If the request fails due to an expired access token, we can refresh
        // the token and then do the request again.
        $infusionsoft->refreshAccessToken();

        $cid = add($infusionsoft);
    }

    $contact = $infusionsoft->contacts()->with('custom_fields')->find($cid->id);

    var_dump($contact->toArray());

    // Save the serialized token to the current session for subsequent requests
    $_SESSION['token'] = serialize($infusionsoft->getToken());
} else {
    echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}