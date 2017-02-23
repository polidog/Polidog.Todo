<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/04/29
 */
namespace Polidog\Todo\Resource\App;

use BEAR\Resource\ResourceObject;
use Ray\AuraSqlModule\AuraSqlInject;

class Todos extends ResourceObject
{
    use AuraSqlInject;

    public function onGet(string $status = null) : ResourceObject
    {
        $this->body = ! empty($status) ?
            $this->pdo->fetchAll('SELECT * FROM todo WHERE status = :status', ['status' => $status])
            : $this->pdo->fetchAll('SELECT * FROM todo');

        return $this;
    }
}
