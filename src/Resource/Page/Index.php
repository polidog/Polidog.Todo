<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Ray\Di\Di\Named;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

class Index extends ResourceObject
{
    use ResourceInject;

    /**
     * @var FormInterface
     */
    public $todoForm;

    /**
     * @Named("todoForm=todo_form")
     */
    public function __construct(FormInterface $todoForm)
    {
        $this->todoForm = $todoForm;
    }

    /**
     * @Embed(rel="todos", src="app://self/todos{?status}")
     */
    public function onGet(string $status = null) : ResourceObject
    {
        $this['todo_form'] = $this->todoForm;
        $this['status'] = (int) $status;

        return $this;
    }

    public function onPost(array $todo = []) : ResourceObject
    {
        return $this->createTodo($todo['title']);
    }

    public function onFailure()
    {
        $this->code = StatusCode::NOT_FOUND;

        return $this->onGet();
    }

    /**
     * @FormValidation(form="todoForm", onFailure="onFailure")
     */
    public function createTodo(string $title) : ResourceObject
    {
        $this->resource
            ->post
            ->uri('app://self/todo')
            ->withQuery(['title' => $title])
            ->eager
            ->request();
        $this->code = StatusCode::MOVED_PERMANENTLY;
        $this->headers[ResponseHeader::LOCATION] = '/';
        $this['todo_form'] = $this->todoForm;

        return $this;
    }
}
