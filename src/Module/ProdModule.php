<?php
namespace Polidog\Todo\Module;

use BEAR\Package\Context\ProdModule as PackageProdModule;
use BEAR\Resource\Module\OptionsMethodModule;
use Ray\Di\AbstractModule;

class ProdModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->install(new OptionsMethodModule);
        $this->install(new PackageProdModule);
    }
}
