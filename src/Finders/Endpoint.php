<?php

namespace Apiboard\OpenAPI\Finders;

use Apiboard\OpenAPI\Structure\Operation;
use Apiboard\OpenAPI\Structure\PathItem;
use Apiboard\OpenAPI\Structure\Server;

final class Endpoint
{
    private PathItem $pathItem;

    private Operation $operation;

    private ?Server $server;

    public function __construct(PathItem $pathItem, Operation $operation, ?Server $server = null)
    {
        $this->pathItem = $pathItem;
        $this->operation = $operation;
        $this->server = $server;
    }

    public function method(): string
    {
        return $this->operation->method();
    }

    public function pathItem(): PathItem
    {
        return $this->pathItem;
    }
}
