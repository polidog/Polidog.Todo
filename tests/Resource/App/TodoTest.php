<?php

namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\ResourceObject;
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
        $this->assertSame(201, $page->code);

        return $page;
    }

    /**
     * @depends testOnPost
     */
    public function testOnGet(ResourceObject $ro)
    {
        $location = $ro->headers['Location'];
        $page = $this->resource->get->uri('app://self' .  $location)->eager->request();
        $this->assertSame(200, $page->code);

        return [$location, $ro];
    }

    /**
     * @depends testOnPost
     */
    public function testOnPut(ResourceObject $ro)
    {
        $location = $ro->headers['Location'];
        $query = ['status' => Todo::COMPLETE];
        $page = $this->resource->put->uri('app://self' .  $location)->addQuery($query)->eager->request();
        $this->assertSame(202, $page->code);
        $get = $this->resource->get->uri('app://self' .  $location)->eager->request();
        $status = $get->body['todo']['status'];
        $this->assertSame(Todo::COMPLETE, (int) $status);
    }

    /**
     * @depends testOnPost
     */
    public function testDelete(ResourceObject $ro)
    {
        $location = $ro->headers['Location'];
        $page = $this->resource->delete->uri('app://self' .  $location)->eager->request();
        $this->assertSame(200, $page->code);
    }
}
