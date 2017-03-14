<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\ResourceInterface;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use BEAR\Package\AppInjector;

class IndexTest extends \PHPUnit_Framework_TestCase
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
        $page = $this->resource->get->uri('page://self/index')->withQuery([])->eager->request();
        $this->assertSame(StatusCode::OK, $page->code);
        $todos = $page['todos'];
        /* @var $todos \BEAR\Resource\AbstractRequest */
        $requestString = $todos->toUri();
        $this->assertSame('app://self/todos', $requestString);

        return $page;
    }

    public function testOnPost()
    {
        $query = ['title' => 'test'];
        $page = $this->resource->post->uri('page://self/index')->withQuery($query)->eager->request();
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::MOVED_PERMANENTLY, $page->code);
        $this->assertSame('/', $page->headers[ResponseHeader::LOCATION]);
    }

    public function testOnPost400()
    {
        $query = ['title' => ''];
        $page = $this->resource->post->uri('page://self/index')->withQuery($query)->eager->request();
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::BAD_REQUEST, $page->code);
    }

    /**
     * @depends testOnGet
     */
    public function testView($page)
    {
        $html = (string) $page;
        $this->assertStringStartsWith('<!DOCTYPE html>', $html);
        $this->assertStringEndsWith(('</html>'), $html);
    }
}
