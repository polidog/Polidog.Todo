<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Package\Bootstrap;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;

class IndexTest extends \PHPUnit_Framework_TestCase
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
        // resource request
        $page = $this->resource->get->uri('page://self/index')->withQuery([])->eager->request();
        $this->assertSame(StatusCode::OK, $page->code);

        return $page;
    }

    public function testOnPost()
    {
        $query = ['todo' => ['title' => 'test']];
        $page = $this->resource->post->uri('page://self/index')->withQuery($query)->eager->request();
        /* @var $page ResourceObject */
        $this->assertSame(StatusCode::MOVED_PERMANENTLY, $page->code);
        $this->assertSame('/', $page->headers[ResponseHeader::LOCATION]);
    }

    public function testOnPost400()
    {
        $query = ['todo' => ['title' => '']];
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
