<?php

use BEAR\Package\Bootstrap;
use Doctrine\Common\Annotations\AnnotationRegistry;

load: {
    $loader = require dirname(__DIR__) . '/vendor/autoload.php';
    AnnotationRegistry::registerLoader([$loader, 'loadClass']);
}
route: {
    /* @global string $context */
    $app = (new Bootstrap)->getApp('Polidog\Todo', $context);
    $req = $app->router->match($GLOBALS, $_SERVER);
}
try {
    $resourceReuest = $app->resource->{$req->method}->uri($req->path)->withQuery($req->query)->request();
    /* @var $resourceReuest \BEAR\Resource\AbstractRequest */
    $resource = $resourceReuest();
    $resource->transfer($app->responder, $_SERVER);
    exit(0);
} catch (\Exception $e) {
    $app->error->handle($e, $req)->transfer();
    exit(1);
}
