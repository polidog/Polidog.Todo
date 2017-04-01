<?php
namespace Polidog\Todo\Resource\App;

use BEAR\Resource\ResourceObject;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;

class Todos extends ResourceObject
{
    use AuraSqlInject;
    use QueryLocatorInject;

    public function onGet(int $status = null) : ResourceObject
    {
        $this->body = $status === null ?
            $this->pdo->fetchAll($this->query['todos_list'])
            : $this->pdo->fetchAll($this->query['todos_item'], ['status' => $status]);

        return $this;
    }
}
