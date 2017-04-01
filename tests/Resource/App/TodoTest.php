<?php
namespace Polidog\Todo\Resource\App;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use PHPUnit\Framework\TestCase;

class TodoTest extends TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        $this->resource = (new AppInjector('Polidog\Todo', 'test-app'))->getInstance(ResourceInterface::class);
    }

    public function testOnPost()
    {
        $page = $this->resource->post->uri('app://self/todo')(['title' => 'test']);
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::CREATED, $page->code);

        return $page;
    }

    /**
     * @depends testOnPost
     */
    public function testOnGet(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $page = $this->resource->uri('app://self' . $location)();
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::OK, $page->code);
    }

    public function testOnGet404()
    {
        $page = $this->resource->uri('app://self/todo?id=0')();
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::NOT_FOUND, $page->code);
    }

    /**
     * @depends testOnPost
     */
    public function testOnPut(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $page = $this->resource->put->uri('app://self' . $location)(['status' => Todo::COMPLETE]);
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::NO_CONTENT, $page->code);
        $get = $this->resource->uri('app://self' . $location)();
        /* @var $get ResourceObject */
        $status = $get->body['todo']['status'];
        $this->assertSame(Todo::COMPLETE, (int) $status);
    }

    /**
     * @depends testOnPost
     */
    public function testDelete(ResourceObject $ro)
    {
        $location = $ro->headers[ResponseHeader::LOCATION];
        $page = $this->resource->delete->uri('app://self' . $location)();
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::NO_CONTENT, $page->code);
        $page = $this->resource->uri('app://self' . $location)();
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::NOT_FOUND, $page->code);
    }
}
