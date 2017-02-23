<?php
namespace Polidog\Todo\Resource\App;

use BEAR\Resource\ResourceObject;
use Koriym\Now\NowInterface;
use Koriym\QueryLocator\QueryLocatorInject;
use Ray\AuraSqlModule\AuraSqlInject;
use Ray\Di\Di\Assisted;

class Todo extends ResourceObject
{
    use AuraSqlInject;
    use QueryLocatorInject;

    const INCOMPLETE = 1;
    const COMPLETE = 2;

    public function onGet(string $id) : ResourceObject
    {
        $todo = $this->pdo->fetchOne($this->query['todo_select'], ['id' => $id]);
        if (empty($todo)) {
            $this->code = 404;

            return $this;
        }
        $todo['status_name'] = $todo['status'] == self::INCOMPLETE ? '完了' : '未完了';
        $this['todo'] = $todo;

        return $this;
    }

    /**
     * @Assisted("now")
     */
    public function onPost(string $title, NowInterface $now = null) : ResourceObject
    {
        $sql = $this->query['todo_insert'];
        $bind = [
            'title' => $title,
            'status' => self::INCOMPLETE,
            'created' => (string) $now,
            'updated' => (string) $now,
        ];
        $statement = $this->pdo->prepare($sql);
        $statement->execute($bind);
        $id = $this->pdo->lastInsertId();
        $this->code = 201;
        $this->headers['Location'] = "/todo?id={$id}";

        return $this;
    }

    public function onPut(string $id, string $status) : ResourceObject
    {
        $sql = $this->query['todo_update'];
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $id,
            'status' => $status
        ]);
        $this->code = 204;
        $this->headers['location'] = '/todo/?id=' . $id;

        return $this;
    }

    public function onDelete(string $id) : ResourceObject
    {
        $sql = $this->query['todo_delete'];;
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $this->code = 204;

        return $this;
    }
}
