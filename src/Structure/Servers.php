<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use ArrayAccess;
use Countable;
use Iterator;

final class Servers implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;

    private array $data;

    public function __construct(array $data)
    {
        $this->data = array_map(fn (array $value) => new Server($value), $data);
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
