<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Package\AppInjector;
use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use PHPUnit\Framework\TestCase;

class IndexTest extends TestCase
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
        $page = $this->resource->uri('page://self/index')();
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::OK, $page->code);
        $todos = $page['todos'];
        /* @var $todos \BEAR\Resource\AbstractRequest */
        $requestString = $todos->toUri();
        $this->assertSame('app://self/todos', $requestString);

        return $page;
    }

    public function testOnPost()
    {
        $page = $this->resource->post->uri('page://self/index')(['title' => 'test']);
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::MOVED_PERMANENTLY, $page->code);
        $this->assertSame('/', $page->headers[ResponseHeader::LOCATION]);
    }

    public function testOnPost400()
    {
        $page = $this->resource->post->uri('page://self/index')(['title' => '']);
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::BAD_REQUEST, $page->code);
    }

    /**
     * @depends testOnGet
     */
    public function testView(ResourceObject $page)
    {
        $html = (string) $page;
        $this->assertStringStartsWith('<!DOCTYPE html>', $html);
        $this->assertStringEndsWith(('</html>'), $html);
    }
}
