<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\ResourceInterface;
use Koriym\HttpConstants\StatusCode;
use Polidog\Todo\AppInjector;

class DoneTest extends \PHPUnit_Framework_TestCase
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
        $page = $this->resource->get->uri('page://self/done')->withQuery($query)->eager->request();
        $this->assertSame(StatusCode::PERMANENT_REDIRECT, $page->code);
    }

    public function getId()
    {
        $query = ['title' => 'test'];
        $this->resource->post->uri('app://self/todo')->withQuery($query)->eager->request();
        $body = $this->resource->get->uri('app://self/todos')->withQuery([])->eager->request()->body;
        $id = $body[0]['id'];

        return $id;
    }
}
