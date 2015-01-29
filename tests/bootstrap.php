<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');
date_default_timezone_set("America/New_York");

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/ServiceTest.php';

$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
	'debug'        => true,
	'includePaths' => [__DIR__.'/../']
]);