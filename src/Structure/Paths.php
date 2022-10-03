<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\AsCountableArray;
use ArrayAccess;
use Countable;

final class Paths implements ArrayAccess, Countable
{
    use AsCountableArray;

    private array $data;

    public function __construct(array $data)
    {
        foreach ($data as $uri=>$value) {
            $data[$uri] = new PathItem($uri, $value);
        }

        $this->data = $data;

        $this->data = $data;
    }

    public function offsetGet(mixed $uri): ?PathItem
    {
        return $this->data[$uri] ?? null;
    }
}
