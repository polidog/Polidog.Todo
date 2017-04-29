<?php
namespace Polidog\Todo\Module;

use Ray\AuraSqlModule\AuraSqlModule;
use Ray\Di\AbstractModule;

class TestModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // install testing data
        $dbConfig = 'sqlite:' . dirname(dirname(__DIR__)) . '/var/db/todo_test.sqlite3';
        $this->install(new AuraSqlModule($dbConfig));
    }
}
