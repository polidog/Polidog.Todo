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


    public function onGet($status = null)
    {
        if (!empty($status)) {
            $this->body = $this->pdo->fetchAll("SELECT * FROM todo WHERE status = :status",[
                'status' => $status
            ]);
        } else {
            $this->body = $this->pdo->fetchAll("SELECT * FROM todo");
        }
        return $this;
    }
}