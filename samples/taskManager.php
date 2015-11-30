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

function taskManager($infusionsoft) {
	$tasks = $infusionsoft->tasks();

	// first, create a new task
	$task = $tasks->create([
		'title' => 'Test Task',
		'description' => 'This is the task description'
	]);

	// oops, we wanted a different title
	$task->title = 'Real Test Task';
	$task->save();

	return $task;
}

if ($infusionsoft->getToken()) {
	try {
		$task = taskManager($infusionsoft);
	}
	catch (\Infusionsoft\TokenExpiredException $e) {
		// If the request fails due to an expired access token, we can refresh
		// the token and then do the request again.
		$infusionsoft->refreshAccessToken();

		// Save the serialized token to the current session for subsequent requests
		$_SESSION['token'] = serialize($infusionsoft->getToken());

		$task = taskManager($infusionsoft);
	}

	var_dump($task);
}
else {
	echo '<a href="' . $infusionsoft->getAuthorizationUrl() . '">Click here to authorize</a>';
}
