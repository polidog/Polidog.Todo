<?php

namespace Polidog\Todo\Resource\Page;

use BEAR\Package\Bootstrap;

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
        $this->assertSame(200, $page->code);

        return $page;
    }

    /**
     * @depends testOnGet
     */
    public function testView($page)
    {
        $html = (string) $page;
        $this->assertStringStartsWith('<!DOCTYPE html>', $html);
        $this->assertStringEndsWith(('</html>'), $html);
        $expected = '<td>1</td>
                                    <td>test</td>';
        $this->assertContains($expected, $html);
    }
}
