<?php

// Turn on all errors.
error_reporting(E_ALL);

// Require Composer autoloader.
require dirname(dirname(__DIR__)).'/vendor/autoload.php';

// Setup AspectMock
$kernel = \AspectMock\Kernel::getInstance();
$kernel->init([
    'debug'        => true,
    'includePaths' => [__DIR__.'/../src'],
]);
