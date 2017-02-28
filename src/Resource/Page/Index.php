<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\Annotation\Link;
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

    /**
     * @FormValidation(form="todoForm", onFailure="onFailure")
     * @Link(rel="create", href="app://self/todo", method="post")
     */
    public function onPost(string $title) : ResourceObject
    {
        $this->resource->href('create', ['title' => $title]);
        $this->code = StatusCode::MOVED_PERMANENTLY;
        $this->headers[ResponseHeader::LOCATION] = '/';
        $this['todo_form'] = $this->todoForm;

        return $this;
    }

    public function onFailure()
    {
        $this->code = StatusCode::BAD_REQUEST;

        return $this->onGet();
    }
}
