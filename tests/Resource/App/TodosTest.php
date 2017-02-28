<?php
namespace Polidog\Todo\Resource\App;

use BEAR\Resource\ResourceInterface;
use Polidog\Todo\AppInjector;

class TodosTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \BEAR\Resource\ResourceInterface
     */
    private $resource;

    protected function setUp()
    {
        $this->resource = (new AppInjector('Polidog\Todo', 'prod-test-app'))->getInstance(ResourceInterface::class);
    }

    public function testOnPost()
    {
        $page = $this->resource->get->uri('app://self/todos')->withQuery(['status' => TODO::COMPLETE])->eager->request();
        $this->assertSame(200, $page->code);

        return $page;
    }
}
