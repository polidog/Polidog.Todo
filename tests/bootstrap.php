<?php

error_reporting(E_ALL);

require dirname(__DIR__) . '/bin/autoload.php';

// set the resource client
copy(dirname(__DIR__) . '/var/db/todo_test.dist.sqlite3', dirname(__DIR__) . '/var/db/todo_test.sqlite3');
