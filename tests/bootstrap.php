<?php

use Doctrine\Common\Annotations\AnnotationRegistry;

error_reporting(E_ALL);

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

// set the resource client
copy(dirname(__DIR__) . '/var/db/todo_test.dist.sqlite3', dirname(__DIR__) . '/var/db/todo_test.sqlite3');
