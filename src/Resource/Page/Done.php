<?php
namespace Polidog\Todo\Resource\Page;

use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Polidog\Todo\Resource\App\Todo;

class Done extends ResourceObject
{
    use ResourceInject;

    public function onGet(string $id) : ResourceObject
    {
        /** @var ResourceObject $res */
        $res = $this->resource
            ->put
            ->uri('app://self/todo')
            ->withQuery([
                'id' => $id,
                'status' => Todo::COMPLETE
            ])
            ->eager
            ->request();

        if ($res->code === 202) {
            $this->code = 301;
            $this->headers['Location'] = '/';

            return $this;
        }

        $this->code = $res->code;

        return $this;
    }
}
