# Polidog.Todo

[![Build Status](https://travis-ci.org/polidog/Polidog.Todo.svg?branch=master)](https://travis-ci.org/polidog/Polidog.Todo)

This is a "Todos" example app built on the principles described in the [Coding Guide](http://bearsunday.github.io/manuals/1.0/en/coding-guide.html).

Optional modules:

  * [ray/aura-sql-module](https://github.com/ray-di/Ray.AuraSqlModule) - Extended PDO ([Aura.Sql](https://github.com/auraphp/Aura.Sql))
  * [ray/web-form-module](https://github.com/ray-di/Ray.WebFormModule) - Web form ([Aura.Input](https://github.com/auraphp/Aura.Input))
  * [madapaja/twig-module](https://github.com/madapaja/Madapaja.TwigModule) - Twig template engine
  * [koriym/now](https://github.com/koriym/Koriym.Now) - Current datetime
  * [koriym/query-locator](https://github.com/koriym/Koriym.QueryLocator) - SQL locator

## Prerequirests

  * php 7.0.0 and up

## Installation

    composer install
    composer setup

## Usage

### Run server

    COMPOSER_PROCESS_TIMEOUT=0 composer serve

## Web access with curl

Return 405 response when unavailable method is requested. 

```
curl -i -X DELETE http://127.0.0.1:8080/
```

```
HTTP/1.1 405 Method Not Allowed
Host: 127.0.0.1:8080
Date: Wed, 31 May 2017 23:09:17 +0200
content-type: application/json

{
    "message": "Method Not Allowed"
}
```

OPTIONS request supported ([RFC2616](https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.2))

> The OPTIONS method represents a request for information about the communication options available on the request/response chain identified by the Request-URI. This method allows the client to determine the options and/or requirements associated with a resource, or the capabilities of a server, without implying a resource action or initiating a resource retrieval.
```
curl -i -X OPTIONS http://127.0.0.1:8080/
```

```
HTTP/1.1 200 OK
Host: 127.0.0.1:8080
Date: Wed, 31 May 2017 23:04:50 +0200
Connection: close
X-Powered-By: PHP/7.1.4
Content-Type: application/json
Allow: GET, POST

{
    "GET": {
        "summary": "Todos list",
        "description": "Returns the todos list specified by status",
        "parameters": {
            "status": {
                "type": "string",
                "description": "todo status"
            }
        }
    },
    "POST": {
        "summary": "Create todo",
        "description": "Create todo and add to todos list",
        "parameters": {
            "title": {
                "type": "string",
                "description": "todo title"
            }
        },
        "required": [
            "title"
        ]
    }
}
```

[`Etag`](https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.19) and [`Last-modifed`](https://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.29)  heaeder supported in @Cacheable GET request.

> The ETag response-header field provides the current value of the entity tag for the requested variant. 

> HTTP/1.1 servers SHOULD send Last-Modified whenever feasible.

```
curl -i http://127.0.0.1:8080/
```

```
HTTP/1.1 200 OK
Host: 127.0.0.1:8080
Date: Wed, 31 May 2017 23:19:49 +0200
Connection: close
X-Powered-By: PHP/7.1.4
ETag: 3652022809
Last-Modified: Wed, 31 May 2017 21:04:45 GMT
content-type: text/html; charset=utf-8

<!DOCTYPE html>
<html>
...
```

Return [`304`](https://tools.ietf.org/html/rfc7232#section-4.1) (Not modifed) response supported on conditional `GET` request. 

> The If-None-Match request-header field is used with a method to make it conditional. A client that has one or more entities previously obtained from the resource can verify that none of those entities is current by including a list of their associated entity tags in the If-None-Match header field. 

```
curl -i -H 'If-None-Match: 3652022809' http://127.0.0.1:8080/
```

```
HTTP/1.1 304 Not Modified
Host: 127.0.0.1:8080
Date: Wed, 31 May 2017 23:56:31 +0200
Connection: close
X-Powered-By: PHP/7.1.4
```

### Console acess

    composer web get /
    composer api options /

### QA

    composer test       // phpunit
    composer coverage   // test coverate
    composer cs         // lint
    composer cs-fix     // lint fix
    vendor/bin/phptest  // test + cs
    vendor/bin/phpbuild // phptest + doc + qa

![](/docs/bear.png)
