<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Polidog\Todo\Resource\App\Todo;

class TodosTest extends \PHPUnit_Framework_TestCase
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
        $page = $this->resource->get->uri('app://self/todos')->withQuery(['status' => TODO::COMPLETE])->eager->request();
        $this->assertSame(200, $page->code);

        return $page;
    }
}
