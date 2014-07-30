<?php

session_start();

require_once '../vendor/autoload.php';

$infusionsoft = new \Infusionsoft\Infusionsoft(array(
    'clientId' => 'CLIENT_ID',
    'clientSecret' => 'CLIENT_SECRET',
    'redirectUri' => 'REDIRECT_URL',
));

// If the access token is available in the session storage, we tell the SDK to
// use that token for subsequent requests.
if (isset($_SESSION['access_token'])) {
    $infusionsoft->setAccessToken($_SESSION['access_token']);
}

// If we are returning from Infusionsoft we need to exchange the code for an
// access token.
if (isset($_GET['code']) and !$infusionsoft->getAccessToken()) {
    $infusionsoft->requestAccessToken($_GET['code']);
}

if ($infusionsoft->getAccessToken()) {
    // Save the access token to the session so we don't keep exchanging the code
    $_SESSION['access_token'] = $infusionsoft->getAccessToken();

    $cid = $infusionsoft->contacts->addWithDupCheck(array('FirstName' => 'John', 'LastName' => 'Doe', 'Email' => 'johndoe@mailinator.com'), 'Email');

    $contact = $infusionsoft->contacts->load($cid, array('Id', 'FirstName', 'LastName', 'Email'));

    var_dump($contact);

} else {
    echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}
