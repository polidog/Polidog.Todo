<?php

namespace Polidog\Todo\Resource\Page;

use BEAR\Package\Bootstrap;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;

class DoneTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $app = (new Bootstrap())->getApp('Polidog\Todo', 'test-html-app');
        $this->resource = $app->resource;
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
