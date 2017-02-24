<?php

namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Polidog\Todo\Resource\App\Todo;

class TodoTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();
        $this->resource = clone $GLOBALS['RESOURCE'];
    }

    public function testOnPost()
    {
        $query = ['title' => 'test'];
        $page = $this->resource->post->uri('app://self/todo')->withQuery($query)->eager->request();
        $this->assertSame(StatusCode::CREATED, $page->code);

        return $page;
    }

    /**
     * @depends testOnPost
     */
    public function testOnGet(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $page = $this->resource->get->uri('app://self' .  $location)->eager->request();
        $this->assertSame(StatusCode::OK, $page->code);

        return [$location, $ro];
    }

    public function testOnGet404()
    {
        $page = $this->resource->get->uri('app://self/todo?id=0')->eager->request();
        $this->assertSame(StatusCode::NOT_FOUND, $page->code);
    }

    /**
     * @depends testOnPost
     */
    public function testOnPut(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $query = ['status' => Todo::COMPLETE];
        $page = $this->resource->put->uri('app://self' .  $location)->addQuery($query)->eager->request();
        $this->assertSame(StatusCode::NO_CONTENT, $page->code);
        $get = $this->resource->get->uri('app://self' .  $location)->eager->request();
        $status = $get->body['todo']['status'];
        $this->assertSame(Todo::COMPLETE, (int) $status);
    }

    /**
     * @depends testOnPost
     */
    public function testDelete(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $page = $this->resource->delete->uri('app://self' .  $location)->eager->request();
        $this->assertSame(StatusCode::NO_CONTENT, $page->code);
        $page = $this->resource->get->uri('app://self' .  $location)->eager->request();
        $this->assertSame(StatusCode::NOT_FOUND, $page->code);
    }
}
