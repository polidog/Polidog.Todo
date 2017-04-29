<?php
namespace Polidog\Todo\Module;

use Madapaja\TwigModule\Annotation\TwigPaths;
use Madapaja\TwigModule\TwigModule;
use Ray\Di\AbstractModule;

class HtmlModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new TwigModule());
        $rootDir = dirname(dirname(__DIR__));
        $paths = [$rootDir . '/var/twig/'];
        $this->bind()->annotatedWith(TwigPaths::class)->toInstance($paths);
    }
}
