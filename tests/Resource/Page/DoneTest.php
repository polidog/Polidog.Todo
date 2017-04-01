<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\StatusCode;
use PHPUnit\Framework\TestCase;

class DoneTest extends TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        $this->resource = (new AppInjector('Polidog\Todo', 'test-html-app'))->getInstance(ResourceInterface::class);
    }

    public function testOnGet()
    {
        $query = ['id' => $this->getId()];
        $page = $this->resource->uri('page://self/done')($query);
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::PERMANENT_REDIRECT, $page->code);
    }

    public function getId()
    {
        $this->resource->post->uri('app://self/todo')(['title' => 'test']);
        $body = $this->resource->uri('app://self/todos')()->body;
        $id = $body[0]['id'];

        return $id;
    }
}
