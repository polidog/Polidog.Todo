<?php
namespace Polidog\Todo\Resource\App;

use BEAR\Package\Annotation\Curies;
use BEAR\Resource\ResourceObject;

/**
 * @Curies(name="pd", href="api.exmaple.com/docs/{rels}", template=true)
 */
class Index extends ResourceObject
{
    public $body = [
        '_links' => [
            'pd:todo' => ['href' => '/todo'],
            'pd:todos' => ['href' =>'/todos']
        ]
    ];

    public function onGet()
    {

        return $this;
    }
}
