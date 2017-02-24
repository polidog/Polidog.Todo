<?php
namespace Polidog\Todo\Module;

use BEAR\Package\PackageModule;
use josegonzalez\Dotenv\Loader as Dotenv;
use Koriym\Now\NowModule;
use Koriym\QueryLocator\QueryLocatorModule;
use Polidog\Todo\Form\TodoForm;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\Di\AbstractModule;
use Ray\WebFormModule\AuraInputModule;
use Ray\WebFormModule\FormInterface;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $rootDir = dirname(dirname(__DIR__));
        Dotenv::load([
            'filepath' => dirname(dirname(__DIR__)) . '/.env',
            'toEnv' => true
        ]);
        $this->install(new PackageModule);

        // Database
        $dbConfig = 'sqlite:' . $rootDir . '/var/db/todo.sqlite3';
        $this->install(new AuraSqlModule($dbConfig));

        // Form
        $this->install(new AuraInputModule());
        $this->bind(TodoForm::class);
        $this->bind(FormInterface::class)->annotatedWith('todo_form')->to(TodoForm::class);
        $this->install(new NowModule());
        $this->install(new QueryLocatorModule($rootDir . '/var/sql'));
    }
}
