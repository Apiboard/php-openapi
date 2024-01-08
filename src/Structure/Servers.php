<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use Apiboard\OpenAPI\References\JsonPointer;
use ArrayAccess;
use Countable;
use Iterator;

final class Servers extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;

    public function __construct(array $data, JsonPointer $pointer = null)
    {
        $data = array_map(fn (array $value) => new Server($value), $data);

        parent::__construct($data, $pointer);
    }

    public function offsetGet(mixed $offset): ?Server
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): Server
    {
        return $this->iterator->current();
    }
}
