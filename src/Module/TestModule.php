<?php
namespace Polidog\Todo\Module;

use BEAR\Package\PackageModule;
use josegonzalez\Dotenv\Loader as Dotenv;
use Polidog\Todo\Form\TodoForm;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\Di\AbstractModule;
use Ray\WebFormModule\AuraInputModule;
use Ray\WebFormModule\FormInterface;

class TestModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        // Database
        $dbConfig = 'sqlite:' . dirname(dirname(__DIR__)). '/var/db/todo_test.sqlite3';
        $this->install(new AuraSqlModule($dbConfig));
    }
}
