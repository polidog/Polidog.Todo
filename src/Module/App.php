<?php
namespace Polidog\Todo\Module;

use BEAR\QueryRepository\HttpCacheInject;
use BEAR\Sunday\Extension\Application\AbstractApp;

class App extends AbstractApp
{
    use HttpCacheInject;
}
