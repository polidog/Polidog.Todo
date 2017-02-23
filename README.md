# BEAR Sunday sample todo

BEAR Sundayで簡単なTodoアプリを作成してみました。
[ブログ記事](http://polidog.jp//2016/04/29/bear/)


## 使い方

```
$ git clone https://github.com/polidog/Polidog.Todo.git
$ composer install
$ cp .env.dist .env
$ mkdir var/db
$ sqlite3 var/db/todo.sqlite3

sqlite3> create table todo(id integer primary key, title, status, created, updated);
sqlite3> .exit


$ php -S 127.0.0.1:8080 var/www/index.php
```

![](/bear.png)