<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Polidog\Todo\Resource\App\Todo;

class Done extends ResourceObject
{
    use ResourceInject;

    /**
     * @Link(rel="complete", href="app://self/todo?status=2", method="put")
     */
    public function onGet(string $id) : ResourceObject
    {
        $this->resource->href('complete', ['id' => $id]);
        $this->code = StatusCode::PERMANENT_REDIRECT;
        $this->headers[ResponseHeader::LOCATION] = '/';

        return $this;
    }
}
