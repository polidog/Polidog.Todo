<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Ray\Di\Di\Inject;
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
     * @Inject()
     * @Named("todoForm=todo_form")
     *
     * Index constructor.
     *
     * @param FormInterface $todoForm
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
        $this->code = 400;

        return $this->onGet();
    }

    /**
     * @FormValidation(form="todoForm", onFailure="onFailure")
     */
    public function createTodo(string $title) : ResourceObject
    {
        $request = $this->resource
            ->post
            ->uri('app://self/todo')
            ->withQuery(['title' => $title])
            ->eager
            ->request();

        $this->code = 301;
        $this->headers['Location'] = '/';
        $this['todo_form'] = $this->todoForm;

        return $this;
    }
}
