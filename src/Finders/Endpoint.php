<?php

namespace Apiboard\OpenAPI\Finders;

use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\PathItem;

final class Endpoint
{
    private PathItem $pathItem;

    private Operation $operation;

    public function __construct(PathItem $pathItem, Operation $operation)
    {
        $this->pathItem = $pathItem;
        $this->operation = $operation;
    }

    public function operation(): Operation
    {
        return $this->operation;
    }

    public function pathItem(): PathItem
    {
        return $this->pathItem;
    }
}
