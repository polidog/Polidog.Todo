<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Koriym\HttpConstants\ResponseHeader;
use Polidog\Todo\Resource\App\Todo;

class Done extends ResourceObject
{
    use ResourceInject;

    public function onGet(string $id) : ResourceObject
    {
        /* @var $ro ResourceObject */
        $ro = $this->resource
            ->put
            ->uri('app://self/todo')
            ->withQuery([
                'id' => $id,
                'status' => Todo::COMPLETE
            ])
            ->eager
            ->request();

        if ($ro->code === 202) {
            $this->code = 301;
            $this->headers[ResponseHeader::LOCATION] = '/';

            return $this;
        }
        $this->code = $ro->code;

        return $this;
    }
}
