<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/04/28
 */

namespace Polidog\Todo\Resource\App;


use BEAR\Resource\ResourceObject;
use Ray\AuraSqlModule\AuraSqlInject;

class Todo extends ResourceObject
{
    use AuraSqlInject;

    const INCOMPLETE = 1;
    const COMPLETE = 2;

    public function onGet($id)
    {
        $todo = $this->pdo->fetchOne("SELECT * FROM todo WHERE id = :id", ['id' => $id]);
        if (empty($todo)) {
            $this->code = 404;
            return $this;
        }
        $todo['status_name'] = $todo['status'] == self::INCOMPLETE ? "完了" : "未完了";
        $this['todo'] = $todo;

        return $this;
    }

    public function onPost($title)
    {
        $sql = 'INSERT INTO todo (title, status, created, updated) VALUES(:title, :status, :created, :updated)';
        $bind = [
            'title' => $title,
            'status' => self::INCOMPLETE,
            'created' => date("Y-m-d H:i:s"),
            'updated' => date("Y-m-d H:i:s"),
        ];
        $statement = $this->pdo->prepare($sql);
        $statement->execute($bind);
        $id = $this->pdo->lastInsertId();
        $this->code = 201;
        $this->headers['Location'] = "/todo?id={$id}";

        return $this;
    }

    public function onPut($id, $status)
    {
        $sql = "UPDATE todo SET status = :status WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            'id' => $id,
            'status' => $status
        ]);
        $this->code = 204;
        $this->headers['location'] = '/todo/?id=' . $id;

        return $this;
    }

    public function onDelete($id)
    {
        $sql = "DELETE FROM todo WHERE id = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(['id' => $id]);
        $this->code = 204;

        return $this;
    }
}
