<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\RepositoryModule\Annotation\Cacheable;
use BEAR\RepositoryModule\Annotation\Refresh;
use BEAR\Resource\Annotation\Embed;
use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Ray\Di\Di\Named;
use Ray\WebFormModule\Annotation\FormValidation;
use Ray\WebFormModule\FormInterface;

/**
 * @Cacheable(type="view", expiry="never")
 */
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
     * Todos list
     *
     * Returns the todos list specified by status
     *
     * @param string $status todo status
     *
     * @Embed(rel="todos", src="app://self/todos{?status}")
     */
    public function onGet(string $status = null) : ResourceObject
    {
        $this['todo_form'] = (string) $this->todoForm;
        $this['status'] = (int) $status;

        return $this;
    }

    /**
     * Create todo
     *
     * Create todo and add to todos list
     *
     * @param string $title todo title
     *
     * @FormValidation(form="todoForm", onFailure="onFailure")
     * @Link(rel="create", href="app://self/todo", method="post")
     * @Refresh(uri="page://self/index")
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
