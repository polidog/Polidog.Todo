<?php
namespace Polidog\Todo\Resource\App;

use BEAR\Resource\ResourceObject;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;

class Todos extends ResourceObject
{
    use AuraSqlInject;
    use QueryLocatorInject;

    public function onGet(string $status = null) : ResourceObject
    {
        $this->body = ! empty($status) ?
            $this->pdo->fetchAll($this->query['todos_item'], ['status' => $status])
            : $this->pdo->fetchAll($this->query['todos_list']);

        return $this;
    }
}
