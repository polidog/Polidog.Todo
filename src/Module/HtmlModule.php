<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/04/28
 */

namespace Polidog\Todo\Module;


use Madapaja\TwigModule\Annotation\TwigPaths;
use Madapaja\TwigModule\TwigModule;
use Ray\Di\AbstractModule;

class HtmlModule extends AbstractModule
{
    protected function configure()
    {
        $this->install(new TwigModule());

        $appDir = dirname(dirname(__DIR__));
        $paths = [$appDir . '/var/twig/'];
        $this->bind()->annotatedWith(TwigPaths::class)->toInstance($paths);
    }

}