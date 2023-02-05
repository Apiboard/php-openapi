<?php

namespace Apiboard\OpenAPI\Structure;

use Apiboard\OpenAPI\Concerns\CanBeUsedAsArray;
use ArrayAccess;
use Countable;
use Iterator;

final class Tags extends Structure implements ArrayAccess, Countable, Iterator
{
    use CanBeUsedAsArray;

    public function __construct(array $data)
    {
        $this->data = array_map(fn (array $value) => new Tag($value), $data);
    }

    public function offsetGet(mixed $offset): ?Tag
    {
        return $this->data[$offset] ?? null;
    }

    public function current(): Tag
    {
        return $this->iterator->current();
    }
}
