<?php

// Initialize database
chdir(dirname(__DIR__) . '/var/db');
passthru('sqlite3 todo.sqlite3 --init todo.sql');
