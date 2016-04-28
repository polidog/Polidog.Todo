<?php
/**
 * Created by PhpStorm.
 * User: polidog
 * Date: 2016/04/29
 */

namespace Polidog\Todo\Resource\Page;


use BEAR\Resource\ResourceObject;
use BEAR\Sunday\Inject\ResourceInject;
use Polidog\Todo\Resource\App\Todo;

class Done extends ResourceObject
{
    use ResourceInject;

    public function onGet($id)
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
            ;

        if ($res->code == 202) {
            header( "HTTP/1.1 301 Moved Permanently" );
            header( "Location: /" );
            exit;
        }

        $this->code = $res->code;
        return $this;
    }
}