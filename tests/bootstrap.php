<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/ServiceTest.php';

$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
	'debug'        => true,
	'includePaths' => [__DIR__.'/../']
]);