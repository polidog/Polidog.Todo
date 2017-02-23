<?php

use BEAR\Package\Bootstrap;
use Doctrine\Common\Annotations\AnnotationRegistry;

error_reporting(E_ALL);

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

// set the application path into the globals so we can access it in the tests.
$_ENV['TEST_DIR'] = __DIR__;
$_ENV['TMP_DIR'] = __DIR__ . '/tmp';

// set the resource client
$app = (new Bootstrap)->getApp('Polidog\Todo', 'test-app');
$GLOBALS['RESOURCE'] = $app->resource;

copy(dirname(__DIR__) . '/var/db/todo_test.dist.sqlite3', dirname(__DIR__) . '/var/db/todo_test.sqlite3');
