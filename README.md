# Polidog.Todo

[![Build Status](https://travis-ci.org/polidog/Polidog.Todo.svg?branch=master)](https://travis-ci.org/polidog/Polidog.Todo)

This is a "Todos" example app built on the principles described in the [Coding Guide](http://bearsunday.github.io/manuals/1.0/en/coding-guide.html). 

Optional modules:

  * [ray/aura-sql-module](https://github.com/ray-di/Ray.AuraSqlModule) - Extended PDO ([Aura.Sql](https://github.com/auraphp/Aura.Sql))
  * [ray/web-form-module](https://github.com/ray-di/Ray.WebFormModule) - Web form ([Aura.Input](https://github.com/auraphp/Aura.Input))
  * [madapaja/twig-module](https://github.com/madapaja/Madapaja.TwigModule) - Twig template engine
  * [koriym/now](https://github.com/koriym/Koriym.Now) - Current datetime
  * [koriym/query-locator](https://github.com/koriym/Koriym.QueryLocator) - SQL locator
  * [koriym/http-constants](https://github.com/koriym/Koriym.HttpConstants) - Contains the values HTTP

## Prerequirests

  * php 7.0.0 and up

## Installation

    composer install
    composer setup

## Usage

### Run server

    composer serve

### Console

    composer web get /
    composer api get /

### QA

    composer test       // phpunit
    composer coverage   // test coverate
    composer cs         // lint
    composer cs-fix     // lint fix
    vendor/bin/phptest  // test + cs
    vendor/bin/phpbuild // phptest + doc + qa

![](/docs/bear.png)
